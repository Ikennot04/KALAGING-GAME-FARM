<?php

namespace App\Http\Controllers\Auth\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Admin\RegisterAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginWebController extends Controller
{
    private RegisterAdmin $registerAdmin;

    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

    public function showLoginForm()
    {
        if (Auth::check() && Session::has('admin_id')) {
            return redirect()->route('home');
        }
        return view('admin.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $admin = $this->registerAdmin->login($credentials['username'], $credentials['password']);
            $adminModel = \App\Infrastructure\Admin\AdminModel::where('id', $admin->getId())->first();
            
            Auth::login($adminModel);
            Session::put('admin_id', $admin->getId());
            Session::put('admin_name', $admin->getName());
            Session::put('last_activity', time());
            
            $intended_url = Session::get('intended_url');
            Session::forget('intended_url');
            
            return redirect()->intended($intended_url ?? route('home'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('message', 'You have been logged out successfully')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
