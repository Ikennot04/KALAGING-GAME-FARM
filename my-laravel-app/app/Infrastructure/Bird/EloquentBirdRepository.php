<?php

namespace App\Infrastructure\Bird;

use App\Domain\Bird\Bird;
use App\Domain\Bird\BirdRepository;
use App\Infrastructure\Bird\BirdModel;
use Carbon\Carbon;

class EloquentBirdRepository implements BirdRepository
{

    /**
     * Create New Bird.
     * **/
    public function create(Bird $bird): void
    {
        $birdModel = BirdModel::find($bird->getId()) ?? new BirdModel();
        $birdModel->id = $bird->getId();
        $birdModel->owner = $bird->getOwner();
        $birdModel->breed = $bird->getBreed();
        $birdModel->image = $bird->getImage();
        $birdModel->handler = $bird->getHandler();
        $birdModel->created_at = Carbon::now()->toDateTimeString();
        $birdModel->updated_at = Carbon::now()->toDateTimeString();
        $birdModel->save();
    }
    /**
     * Update Bird.
     * **/
    public function update(Bird $bird): void
    {
        $existingBird = BirdModel::where(
            'id',
            $bird->getId()
        )->first();
        if ($existingBird) {
            $existingBird->owner = $bird->getOwner();
            $existingBird->breed = $bird->getBreed();
            $existingBird->image = $bird->getImage();
            $existingBird->handler = $bird->getHandler();
            $existingBird->updated_at = $bird->Updated();
            $existingBird->save();
        } else {
            $productBird = new BirdModel();
            $productBird->id = $bird->getId();
            $productBird->owner = $bird->getOwner();
            $productBird->breed = $bird->getBreed();
            $productBird->handler = $bird->getHandler();
            $productBird->image = $bird->getImage();
            $productBird->updated_at = $bird->Updated();
            $productBird->save();
        }
    }
    public function delete(int $id): void
    {
        $birdModel = BirdModel::where('id', $id)->delete();
    }
    public function findById(int $id): ?Bird
    {
        $productBird = BirdModel::find($id);
        if (!$productBird) {
            return null;
        }
        return new Bird(
            $productBird->id,
            $productBird->owner,
            $productBird->handler,
            $productBird->image,
            $productBird->breed,
            $productBird->created_at,
            $productBird->updated_at,


        );
    }
    public function findAll(): array
    {
        return BirdModel::all()->map(fn($productBird) => new Bird(
            $productBird->id,
            $productBird->owner,
            $productBird->handler,
            $productBird->image,
            $productBird->breed,
            $productBird->created_at,
            $productBird->updated_at,
        ))->toArray();
    }
    public function searchBird(string $search): array
    {
        $match = BirdModel::where('handler', $search)->orWhere('owner', $search)->orWhere('breed')->first();

        $related = BirdModel::where('id', '!=', $match?->id)
            ->where('owner', 'LIKE', "%{$search}%")
            ->orWhere('breed', 'LIKE', "%{$search}%")
            ->orWhere('handler', 'LIKE', "%{$search}%")->get();

        return [
            'match' => $match ? new Bird(
                $match->id,
                $match->owner,
                $match->handler,
                $match->image,
                $match->breed,
                $match->created_at,
                $match->updated_at,
            ) : null,
            'related' => $related->map(
                function ($bird) {
                    return new Bird(
                        $bird->id,
                        $bird->owner,
                        $bird->handler,
                        $bird->image,
                        $bird->breed,
                        $bird->created_at,
                        $bird->updated_at,
                    );
                }
            )->toArray()
        ];
    }
}
