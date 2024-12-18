<?php

namespace App\Infrastructure\Worker;

use App\Domain\Worker\Worker;
use App\Domain\Worker\WorkerRepository;
use App\Infrastructure\Worker\WorkerModel;
use App\Infrastructure\Bird\BirdModel;
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
        $workerModel->deleted = 0;
        $workerModel->save();
    }
    public function softDelete(string $id): void
    {
        WorkerModel::where('id', $id)
            ->update(['deleted' => 1]);
    }

    public function restore(string $id): void
    {
        WorkerModel::where('id', $id)
            ->update(['deleted' => 0]);
    }

    public function findAllDeleted(): array
    {
        $deletedWorkers = WorkerModel::archived()->get();
        return $deletedWorkers->map(fn($model) => $this->createWorkerFromModel($model))->all();
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
        $workers = WorkerModel::active()->get();
        return $workers->map(fn($model) => $this->createWorkerFromModel($model))->all();
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

    public function countBirdsByHandler(string $handlerName): int
    {
        return BirdModel::where('handler', $handlerName)
            ->where('deleted', 0)
            ->count();
    }

    public function getHandlerStats(): array
    {
        $workers = WorkerModel::active()->get();
        $stats = [];

        foreach ($workers as $worker) {
            $birds = BirdModel::where('handler', $worker->name)
                ->where('deleted', 0)
                ->get()
                ->map(function($bird) {
                    return [
                        'name' => $bird->breed,
                        'breed' => $bird->breed,
                        'owner' => $bird->owner,
                        'handler' => $bird->handler,
                        'image' => $bird->image
                    ];
                });

            $stats[] = [
                'id' => $worker->id,
                'name' => $worker->name,
                'position' => $worker->position,
                'image' => $worker->image,
                'bird_count' => $birds->count(),
                'birds' => $birds
            ];
        }

        return $stats;
    }
}
