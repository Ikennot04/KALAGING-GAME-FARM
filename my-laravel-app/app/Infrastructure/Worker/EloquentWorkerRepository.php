<?php

namespace App\Infrastructure\Worker;

use App\Domain\Worker\Worker;
use App\Domain\Worker\WorkerRepository;
use App\Infrastructure\Worker\WorkerModel;
use Carbon\Carbon;

class EloquentWorkerRepository implements WorkerRepository
{

    /**
     * Create New Bird.
     * **/
    public function create(Worker $worker): void
    {
        $workerModel = WorkerModel::find($worker->getId()) ?? new WorkerModel();
        $workerModel->id = $worker->getId();
        $workerModel->name = $worker->getName();
        $workerModel->position = $worker->getPosition();
        $workerModel->image = $worker->getImage();
        $workerModel->created_at = Carbon::now()->toDateTimeString();
        $workerModel->updated_at = Carbon::now()->toDateTimeString();
        $workerModel->save();
    }
    /**
     * Update Bird.
     * **/
    public function update(Worker $worker): void
    {
        $existingWorker = WorkerModel::where(
            'id',
            $worker->getId()
        )->first();
        if ($existingWorker) {
            $existingWorker->name = $worker->getName();
            $existingWorker->position = $worker->getPosition();
            $existingWorker->image = $worker->getImage();
            $existingWorker->updated_at = $worker->getUpdatedAt();
            $existingWorker->save();
        } else {
            $productWorker = new WorkerModel();
            $productWorker->id = $worker->getId();
            $productWorker->name = $worker->getName();
            $productWorker->position = $worker->getPosition();
            $productWorker->image = $worker->getImage();
            $productWorker->updated_at = $worker->getUpdatedAt();
            $productWorker->save();
        }
    }
    public function delete(int $id): void
    {
        $workerModel = WorkerModel::where('id', $id)->delete();
    }
    public function findById(int $id): ?Worker
    {
        $workerModel = WorkerModel::find($id);
        return $workerModel ? $this->createWorkerFromModel($workerModel) : null;
    }
    public function findAll(): array
    {
        return WorkerModel::all()
            ->map(fn($model) => $this->createWorkerFromModel($model))
            ->toArray();
    }
    public function searchWorker(string $search): array
    {
        $match = WorkerModel::where('id', $search)
            ->orWhere('name', 'LIKE', "{$search}%")
            ->orWhere('position', 'LIKE', "{$search}%")
            ->first();

        $related = WorkerModel::where(function($query) use ($search) {
            $query->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('position', 'LIKE', "%{$search}%");
        })
        ->when($match, function($query) use ($match) {
            return $query->where('id', '!=', $match->id);
        })
        ->get();

        return [
            'match' => $match ? $this->createWorkerFromModel($match) : null,
            'related' => $related->map(fn($model) => $this->createWorkerFromModel($model))->all()
        ];
    }

    private function createWorkerFromModel(WorkerModel $model): Worker
    {
        return new Worker(
            id: $model->id,
            name: $model->name,
            position: $model->position,
            image: $model->image,
            created_at: $model->created_at,
            updated_at: $model->updated_at
        );
    }
}
