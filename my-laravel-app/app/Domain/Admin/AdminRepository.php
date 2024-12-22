<?php

namespace App\Domain\Admin;

interface AdminRepository
{
    public function create(Admin $admin): array;
    public function update(Admin $admin): void;
    public function findByID(int $id): ?Admin;
    public function findByUsername(string $username): ?Admin;
    public function findAll(): array;
    public function login(string $username, string $password): array;
    public function softDelete(int $id): void;
    public function restore(int $id): void;
}