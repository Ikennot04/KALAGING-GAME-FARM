@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Account Settings</h1>

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                {{ Session::get('success') }}
            </div>
        @endif

        <!-- Error message -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Settings Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Profile Information</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-300">{{ Auth::user()->name }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-300">{{ Auth::user()->username }}</div>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Change Password</h2>
            <form action="{{ route('settings.update.password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Change Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Session Management Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Session Management</h2>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Last activity: 
                            {{ Session::has('last_activity') ? \Carbon\Carbon::createFromTimestamp(Session::get('last_activity'))->diffForHumans() : 'N/A' }}
                        </p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
