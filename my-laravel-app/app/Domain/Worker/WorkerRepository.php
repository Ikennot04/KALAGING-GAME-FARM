<?php

namespace App\Domain\Worker;

interface WorkerRepository
{
    public function create(Worker $worker): void;

    public function update(Worker $worker): void;

    public function delete(int $id): void;

    public function findById(int $id): ?Worker;

    public function findAll(): array;
    public function searchWorker(string $search): array;
}