<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Admin;
use App\Domain\Admin\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EloquentAdminRepository implements AdminRepository
{
    public function create(Admin $admin): array
    {
        $adminModel = new AdminModel();
        $adminModel->name = $admin->getName();
        $adminModel->username = $admin->getUsername();
        $adminModel->password = $admin->getPassword();
        $adminModel->role_id = $admin->getRoleId();
        $adminModel->image = $admin->getImage();
        $adminModel->created_at = Carbon::now()->toDateTimeString();
        $adminModel->updated_at = Carbon::now()->toDateTimeString();
        $adminModel->deleted = 0;
        $adminModel->save();
        
        $token = $adminModel->createToken('auth-token')->plainTextToken;
        
        return [$this->mapToAdmin($adminModel), $token];
    }

    public function update(Admin $admin): void
    {
        $adminModel = AdminModel::find($admin->getId());
        if ($adminModel) {
            $adminModel->name = $admin->getName();
            $adminModel->username = $admin->getUsername();
            $adminModel->image = $admin->getImage();
            if ($admin->getPassword()) {
                $adminModel->password = $admin->getPassword();
            }
            if ($admin->getRoleId()) {
                $adminModel->role_id = $admin->getRoleId();
            }
            $adminModel->updated_at = Carbon::now()->toDateTimeString();
            $adminModel->save();
        }
    }

    public function findByID(int $id): ?Admin
    {
        $model = AdminModel::find($id);
        return $model ? $this->mapToAdmin($model) : null;
    }

    public function findByUsername(string $username): ?Admin
    {
        $model = AdminModel::where('username', $username)->first();
        return $model ? $this->mapToAdmin($model) : null;
    }

    public function findAll(): array
    {
        return AdminModel::active()
            ->get()
            ->map(fn($model) => $this->mapToAdmin($model))
            ->toArray();
    }

    public function login(string $username, string $password): array
    {
        $admin = AdminModel::where('username', $username)->first();
        if (!$admin || !Hash::check($password, $admin->password)) {
            throw new \Exception('Invalid credentials');
        }
        
        $token = $admin->createToken('auth-token')->plainTextToken;
        return [$this->mapToAdmin($admin), $token];
    }

    public function softDelete(int $id): void
    {
        $adminModel = AdminModel::find($id);
        if ($adminModel) {
            $adminModel->deleted = 1;
            $adminModel->save();
        }
    }

    public function restore(int $id): void
    {
        $adminModel = AdminModel::find($id);
        if ($adminModel) {
            $adminModel->deleted = 0;
            $adminModel->save();
        }
    }

    private function mapToAdmin(AdminModel $model): Admin
    {
        return new Admin(
            id: $model->id,
            name: $model->name,
            username: $model->username,
            password: $model->password,
            role_id: $model->role_id,
            image: $model->image,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            deleted: $model->deleted
        );
    }

}


