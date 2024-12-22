@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users-cog me-2"></i>Account Management
                    </h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-5">
                        <h5 class="text-center text-primary mb-3">Create New Account</h5>
                        <form method="POST" action="{{ route('admin.register') }}" id="createAccountForm" class="p-4 border rounded bg-light shadow-sm" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" 
                                    id="username" 
                                    name="username" 
                                    value="{{ old('username') }}" 
                                    required 
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select id="role_id" 
                                    name="role_id" 
                                    required 
                                    class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="0" {{ old('role_id') == '0' ? 'selected' : '' }}>User</option>
                                    <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Handler</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                    id="password" 
                                    name="password" 
                                    required 
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="c_password" class="form-label">Confirm Password</label>
                                <input type="password" 
                                    id="c_password" 
                                    name="c_password" 
                                    required 
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture</label>
                                <input type="file" 
                                    id="image" 
                                    name="image" 
                                    accept="image/*"
                                    class="form-control">
                                <div class="mt-2">
                                    <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 100px; max-height: 100px;" class="rounded-circle">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-5">
                        <!-- Users Table -->
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Users</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Profile</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    @if($user->role_id === 0)
                                                        <tr>
                                                            <td>
                                                                <img src="{{ asset('storage/images/' . ($user->image ?? 'default-profile.jpg')) }}" 
                                                                     alt="{{ $user->name }}" 
                                                                     class="h-10 w-10 rounded-full object-cover">
                                                            </td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->username }}</td>
                                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-sm btn-warning me-1" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-danger" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Handlers Table -->
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Handlers</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Profile</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Worker Status</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    @if($user->role_id === 1)
                                                        <tr>
                                                            <td>
                                                                <img src="{{ asset('storage/images/' . ($user->worker ? $user->worker->getImage() : ($user->image ?? 'default-profile.jpg'))) }}" 
                                                                     alt="{{ $user->name }}" 
                                                                     class="h-10 w-10 rounded-full object-cover">
                                                            </td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->username }}</td>
                                                            <td>
                                                                @if($user->worker)
                                                                    <span class="badge bg-success">Active Worker</span>
                                                                @else
                                                                    <span class="badge bg-warning">No Worker Profile</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-sm btn-warning me-1" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-danger" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center bg-light">
                    <small class="text-muted">© {{ date('Y') }} Account Management System</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    }

    if(file) {
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
