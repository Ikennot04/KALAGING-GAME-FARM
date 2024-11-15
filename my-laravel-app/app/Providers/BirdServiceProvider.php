<?php

namespace App\Services;

use App\Domain\Bird\Bird;
use App\Domain\Bird\BirdRepository;

class BirdService
{
    private BirdRepository $birdRepository;

    public function __construct(BirdRepository $birdRepository)
    {
        $this->birdRepository = $birdRepository;
    }

    public function createBird(array $data): void
    {
        $bird = new Bird(
            null,
            $data['owner'],
            $data['handler'],
            $data['image'],
            null,
            null,
            $data['breed']
        );

        $this->birdRepository->create($bird);
    }

    public function getBirdById(int $id): ?Bird
    {
        return $this->birdRepository->findById($id);
    }

    public function updateBird(int $id, array $data): bool
    {
        $bird = $this->birdRepository->findById($id);

        if (!$bird) {
            return false;
        }

        $updatedBird = new Bird(
            $id,
            $data['owner'],
            $data['handler'],
            $data['image'],
            $bird->Created(),
            now(),
            $data['breed']
        );

        $this->birdRepository->update($updatedBird);

        return true;
    }

    public function deleteBird(int $id): bool
    {
        $bird = $this->birdRepository->findById($id);

        if (!$bird) {
            return false;
        }

        $this->birdRepository->delete($id);

        return true;
    }
}
