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
        $birdModel->deleted = 0;
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
        $birdModel = BirdModel::find($id);
        return $birdModel ? $this->createBirdFromModel($birdModel) : null;
    }
    public function findAll(): array
    {
        $birds = BirdModel::active()->get();
        return $birds->map(fn($model) => $this->createBirdFromModel($model))->all();
    }
    public function searchBird(string $search): array
    {
        $match = BirdModel::where('id', $search)
            ->orWhere('breed', $search)
            ->orWhere('owner', $search)
            ->orWhere('handler', $search)
            ->first();

        $related = BirdModel::where(function($query) use ($search) {
            $query->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('breed', 'LIKE', "%{$search}%")
                  ->orWhere('owner', 'LIKE', "%{$search}%")
                  ->orWhere('handler', 'LIKE', "%{$search}%");
        })
        ->when($match, function($query) use ($match) {
            return $query->where('id', '!=', $match->id);
        })
        ->get();

        return [
            'match' => $match ? $this->createBirdFromModel($match) : null,
            'related' => $related->map(fn($model) => $this->createBirdFromModel($model))->all()
        ];
    }

    public function softDelete(string $id): void
    {
        BirdModel::where('id', $id)
            ->update(['deleted' => 1]);
    }

    public function restore(string $id): void
    {
        BirdModel::where('id', $id)
            ->update(['deleted' => 0]);
    }

    public function findAllDeleted(): array
    {
        $deletedBirds = BirdModel::archived()->get();
        return $deletedBirds->map(fn($model) => $this->createBirdFromModel($model))->all();
    }

    private function createBirdFromModel(BirdModel $model): Bird
    {
        return new Bird(
            id: $model->id,
            owner: $model->owner,
            handler: $model->handler,
            image: $model->image,
            breed: $model->breed,
            created_at: $model->created_at,
            updated_at: $model->updated_at
        );
    }
}
