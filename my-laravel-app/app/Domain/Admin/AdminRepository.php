<?php

namespace App\Domain\Admin;

interface AdminRepository
{
    public function create(Admin $admin);
    public function update(Admin $admin): void;
    public function findByID(int $id): ?Admin;
    public function findByUsername(string $username): ?Admin;
    public function findAll(): array;
    public function addApiToken(int $id, string $apiToken): void;
    public function updateToken(int $id, string $apiToken): void;
    public function login(string $username, string $password);
}