<?php

namespace App\Domain\Bird;

interface BirdRepository
{
    public function create(Bird $bird): void;

    public function update(Bird $bird): void;

    public function delete(int $id): void;

    public function findById(int $id): ?Bird;

    public function findAll(): array;
}
