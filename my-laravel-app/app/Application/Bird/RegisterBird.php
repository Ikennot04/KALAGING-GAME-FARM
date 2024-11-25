<?php

namespace App\Application\Bird;

use App\Domain\Bird\BirdRepository;
use App\Domain\Bird\Bird;

class RegisterBird
{
    private BirdRepository $birdRepository;

    public function __construct(BirdRepository $birdRepository)
    {
        $this->birdRepository = $birdRepository;
    }
    public function create(
        string $owner,
        string $handler,
        string $image,
        string $breed,
        string $created_at,
        string $updated_at
    ) {
        $data = new Bird(
            id: null,
            owner: $owner,
            handler: $handler,
            image: $image,
            breed: $breed,
            created_at: $created_at,
            updated_at: $updated_at
        );
        $this->birdRepository->create($data);
    }
    public function update(string $id, string $owner, string $handler, string $image, string $breed, string $updated_at)
    {
        $validate = $this->birdRepository->findById($id);

        if (!$validate) {
            throw new \Exception('Bird Not found!');
        }

        $updateBird = new Bird(
            id: $id,
            owner: $owner,
            handler: $handler,
            image: $image,
            breed: $breed,
            created_at: $validate->Created(),
            updated_at: $updated_at
        );
        
        $this->birdRepository->update($updateBird);
    }


    public function findByBirdID(int $id)
    {
        return $this->birdRepository->findById($id);
    }
    public function delete(string $id)
    {

        $this->birdRepository->delete($id);
    }
    public function findAll(): array
    {
        return $this->birdRepository->findAll();
    }
    public function search(string $search): array
    {
        $results = $this->birdRepository->searchBird($search);
        
        return [
            'match' => $results['match'] ? $results['match'] : null,
            'related' => $results['related'] ?? []
        ];
    }
}