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
    
    public function updateToken(int $id, string $apiToken)
    {
       return $this->adminRepository->updateToken($id, $apiToken);
    }
    public function login(string $username, string $password)
    {
        return $this->adminRepository->login($username, $password);
    }
    public function create(string $name, string $username, string $password)
    {
        $admin = new Admin(
            name: $name,
            username: $username,
            password: Hash::make($password),
        );
        return $this->adminRepository->create($admin);
    }
    public function update(int $id, string $name, string $username, string $password)
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
    public function addApiToken(int $id, string $apiToken)
    {
        $this->adminRepository->addApiToken($id, $apiToken);
    }

}
