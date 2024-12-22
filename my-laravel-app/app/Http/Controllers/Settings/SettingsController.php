<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Application\Admin\RegisterAdmin;

class SettingsController extends Controller
{
    private RegisterAdmin $registerAdmin;

    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

    public function show()
    {
        $this->validateSession();
        return view('Pages.Settings.settings');
    }

    public function updateProfile(Request $request)
    {
        $this->validateSession();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
        ]);

        try {
            $this->registerAdmin->update(
                Auth::id(),
                $request->name,
                $request->username,
                Auth::user()->password
            );

            return back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update profile']);
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validateSession();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        try {
            $this->registerAdmin->update(
                Auth::id(),
                Auth::user()->name,
                Auth::user()->username,
                Hash::make($request->new_password)
            );

            return back()->with('success', 'Password changed successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update password']);
        }
    }

    private function validateSession()
    {
        if (!Auth::check() || !Session::has('admin_id')) {
            Auth::logout();
            Session::flush();
            return redirect()->route('admin.login')->with('error', 'Please login to continue');
        }
        return null;
    }
} 