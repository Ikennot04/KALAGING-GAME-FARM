<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\AdminRepository;
use App\Domain\Admin\Admin;
use Illuminate\Support\Facades\Hash;

class EloquentAdminRepository implements AdminRepository
{
    public function create(Admin $admin)
    {
        $adminModel = new AdminModel();
        $adminModel->name = $admin->getName();
        $adminModel->username = $admin->getUsername();
        $adminModel->password = $admin->getPassword();
        $adminModel->save();
        
        $token = $adminModel->createToken('auth_token')->plainTextToken;
        
        return new Admin(
            id: $adminModel->id,
            name: $adminModel->name,
            username: $adminModel->username,
            apiToken: $token,
            created_at: $adminModel->created_at,
            updated_at: $adminModel->updated_at
        );
    }

    public function update(Admin $admin): void
    {
        $adminModel = AdminModel::find($admin->getId());
        if ($adminModel) {
            $adminModel->name = $admin->getName();
            $adminModel->username = $admin->getUsername();
            if ($admin->getPassword()) {
                $adminModel->password = $admin->getPassword();
            }
            $adminModel->save();
        }
    }

    public function findByID(int $id): ?Admin
    {
        $model = AdminModel::find($id);
        if (!$model) return null;
        
        return new Admin(
            id: $model->id,
            name: $model->name,
            username: $model->username,
            apiToken: $model->api_token
        );
    }

    public function findByUsername(string $username): ?Admin
    {
        $model = AdminModel::where('username', $username)->first();
        if (!$model) return null;
        
        return new Admin(
            id: $model->id,
            name: $model->name,
            username: $model->username,
            apiToken: $model->api_token
        );
    }

    public function findAll(): array
    {
        return AdminModel::all()
            ->map(fn($model) => new Admin(
                id: $model->id,
                name: $model->name,
                username: $model->username,
                apiToken: $model->api_token
            ))
            ->toArray();
    }

    public function addApiToken(int $id, string $apiToken): void
    {
        AdminModel::where('id', $id)->update(['api_token' => $apiToken]);
    }

    public function updateToken(int $id, string $apiToken): void
    {
        AdminModel::where('id', $id)->update(['api_token' => $apiToken]);
    }

    public function login(string $username, string $password)
    {
        $admin = AdminModel::where('username', $username)->first();
        if (!$admin || !Hash::check($password, $admin->password)) {
            throw new \Exception('Invalid credentials');
        }
        
        $token = $admin->createToken('auth_token')->plainTextToken;
        
        return new Admin(
            id: $admin->id,
            name: $admin->name,
            username: $admin->username,
            apiToken: $token,
            created_at: $admin->created_at,
            updated_at: $admin->updated_at
        );
    }
}


