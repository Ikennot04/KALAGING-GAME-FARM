<?php

namespace App\Application\Worker;

use App\Domain\Worker\WorkerRepository;
use App\Domain\Worker\Worker;

class RegisterWorker
{
    private $workerRepository;

    public function __construct(WorkerRepository $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }

    public function create(
        string $name,
        string $position,
        string $image,
        string $created_at,
        string $updated_at
    ) {
        $data = new Worker(
            id: null,
            name: $name,
            position: $position,
            image: $image,
            created_at: $created_at,
            updated_at: $updated_at
        );
        $this->workerRepository->create($data);
    }
    public function update(string $id, string $name, string $position, string $image, string $updated_at)
    {
        $validate = $this->workerRepository->findById($id);

        if (!$validate) {
            throw new \Exception('Worker Not found!');
        }

        $updateWorker = new Worker(
            id: $id,
            name: $name,
            position: $position,
            image: $image,
            created_at: $validate->getCreatedAt(),
            updated_at: $updated_at
        );
        
        $this->workerRepository->update($updateWorker);
    }


    public function findByWorkerID(int $id)
    {
        return $this->workerRepository->findByID($id);
    }
    public function delete(string $id)
    {

        $this->workerRepository->delete($id);
    }
    public function findAll(): array
    {
        return $this->workerRepository->findAll();
    }
    public function search(string $search): array
    {
        $results = $this->workerRepository->searchWorker($search);
        
        return [
            'match' => $results['match'] ? $results['match'] : null,
            'related' => $results['related'] ?? []
        ];
    }
}
