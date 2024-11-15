<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Bird\Bird;
use App\Domain\Bird\BirdRepository;
use App\Models\Bird as BirdModel;

class EloquentBirdRepository implements BirdRepository
{
    public function create(Bird $bird): Bird
    {
        $model = new BirdModel();
        // Map Bird entity properties to Eloquent model attributes
        $model->owner = $bird->getOwner();
        $model->handler = $bird->getHandler();
        $model->image = $bird->getImage();
        $model->breed = $bird->getBreed();
        $model->save();

        // Update Bird entity with the assigned ID and timestamps
        return new Bird(
            $model->id,
            $model->owner,
            $model->handler,
            $model->image,
            $model->created_at,
            $model->updated_at,
            $model->breed
        );
    }

    // Implement other methods similarly, such as update, delete, findById, findAll
}
