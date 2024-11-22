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
            null,
            $owner,
            $handler,
            $image,
            $breed,
            $created_at,
            $updated_at,
        );
        $this->birdRepository->create($data);
    }
    public function update(string $id, string $owner, string $handler, string $image, string $breed, string $updated_at)
    {
        $validate = $this->birdRepository->findById($id);

        if (!$validate) {
            throw new \Exception('Product Not found!');
        }
        $updateBird = new Bird(

            id: $id,
            owner: $owner,
            handler: $handler,
            image: $image,
            breed: $breed,
            updated_at: $updated_at,
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
        $bird = $this->birdRepository->searchBird($search);
        return [
            'match' => $bird['match'] ? $bird['match']->toArray() : null,
            'related' => array_map(function ($bird) {
                return $bird->toArray();
            }, $bird['related'])
        ];
    }
}