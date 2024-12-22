<?php

namespace App\Application\Admin;

use App\Domain\Admin\Admin;
use App\Infrastructure\Admin\EloquentAdminRepository;
use Illuminate\Support\Facades\Hash;

class RegisterAdmin
{
    public function __construct(private EloquentAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    
    public function login(string $username, string $password)
    {
        $result = $this->adminRepository->login($username, $password);
        if (!$result) {
            throw new \Exception('Invalid credentials');
        }
        return $result;
    }

    public function create(string $name, string $username, string $password, int $role_id, ?string $image = 'default-profile.jpg')
    {
        $admin = new Admin(
            name: $name,
            username: $username,
            password: Hash::make($password),
            role_id: $role_id,
            image: $image
        );
        return $this->adminRepository->create($admin);
    }

    public function update(int $id, string $name, string $username, string $password, string $image, string $updated_at)
    {
        $validate = $this->adminRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Admin Not Found!');
        }
        $updateUser = new Admin(
            id: $id,
            name: $name,
            username: $username,
            password: $password,
            image: $image,
            created_at: $validate->Created(),
            updated_at: $updated_at
        );
        $this->adminRepository->update($updateUser);
    }

    public function findByID(int $id)
    {
        return $this->adminRepository->findByID($id);
    }

    public function findByUsername(string $username)
    {
        return $this->adminRepository->findByUsername($username);
    }

    public function findAll(): array
    {
        return $this->adminRepository->findAll();
    }

    public function softDelete(int $id): void
    {
        $this->adminRepository->softDelete($id);
    }

    public function restore(int $id): void
    {
        $this->adminRepository->restore($id);
    }
}
