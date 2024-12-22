<?php

namespace App\Http\Controllers\Auth\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Admin\RegisterAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Application\Enums\UserRole;
use Illuminate\Http\JsonResponse;
use App\Infrastructure\Worker\WorkerModel;
use Illuminate\Support\Facades\Storage;
use App\Infrastructure\Admin\AdminModel;

class LoginWebController extends Controller
{
    private RegisterAdmin $registerAdmin;

    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('admin.admin-login');
    }

    public function showRegisterForm()
    {
        if (!Auth::check() || Auth::user()->role_id !== UserRole::ADMIN) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access');
        }
        return view('Pages.Accounts.User-Handler_Account.index', [
            'roles' => [
                ['id' => UserRole::USER, 'name' => 'User'],
                ['id' => UserRole::HANDLER, 'name' => 'Handler']
            ]
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users',
                'password' => 'required|string|min:6',
                'c_password' => 'required|same:password',
                'role_id' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->except(['password', 'c_password']));
            }

            if ($request->input('role_id') == UserRole::ADMIN && 
                (!Auth::check() || Auth::user()->role_id !== UserRole::ADMIN)) {
                return redirect()->back()->with('error', 'Unauthorized to create admin users');
            }

            $input = $request->all();
            $imageName = 'default-profile.jpg';

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
                Storage::disk('public')->putFileAs('images', $image, $imageName);
            }

            [$admin, $token] = $this->registerAdmin->create(
                $input['name'],
                $input['username'],
                $input['password'],
                $input['role_id'],
                $imageName
            );

            // If the created user is a handler, create a worker entry
            if ($input['role_id'] == UserRole::HANDLER) {
                $worker = new WorkerModel();
                $worker->name = $input['name'];
                $worker->position = 'Handler';
                $worker->image = $imageName;
                $worker->user_id = $admin->getId();
                $worker->deleted = 0;
                $worker->save();
            }

            return redirect()->back()->with('success', 'Account created successfully');
        } catch (\Exception $e) {
            if (isset($imageName) && $imageName !== 'default-profile.jpg') {
                Storage::disk('public')->delete('images/' . $imageName);
            }
            return redirect()->back()->with('error', 'Failed to create account: ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            [$adminModel, $token] = $this->registerAdmin->login($credentials['username'], $credentials['password']);
            
            if (!$adminModel) {
                throw new \Exception('Invalid credentials');
            }

            // Clear any existing sessions first
            Session::flush();
            Auth::logout();
            
            // Start new session
            $request->session()->regenerate();
            
            // Login and set session data
            Auth::login($adminModel);
            Session::put('admin_id', $adminModel->id);
            Session::put('last_activity', time());
            
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            return back()
                ->withErrors(['username' => 'The provided credentials do not match our records.'])
                ->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    public function showAccounts()
    {
        if (!Auth::check() || !Session::has('admin_id')) {
            Auth::logout();
            Session::flush();
            return redirect()->route('admin.login')->with('error', 'Please login to continue');
        }

        if (Auth::user()->role_id !== UserRole::ADMIN) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }
        
        $users = $this->registerAdmin->findAll();
        return view('Pages.Accounts.User-Handler_Account.index', [
            'users' => $users,
            'roles' => [
                ['id' => UserRole::USER, 'name' => 'User'],
                ['id' => UserRole::HANDLER, 'name' => 'Handler']
            ]
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = $this->registerAdmin->findByID($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username,' . $id,
                'role_id' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $imageName = $user->getImage();

            if ($request->hasFile('image')) {
                if ($imageName && $imageName !== 'default-profile.jpg') {
                    Storage::disk('public')->delete('images/' . $imageName);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                Storage::disk('public')->putFileAs('images', $image, $imageName);
            }

            $this->registerAdmin->update(
                $id,
                $validated['name'],
                $validated['username'],
                $imageName,
                $validated['role_id'],
                now()->toDateTimeString()
            );

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            \Log::error('User update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update user: ' . $e->getMessage()], 500);
        }
    }
}
