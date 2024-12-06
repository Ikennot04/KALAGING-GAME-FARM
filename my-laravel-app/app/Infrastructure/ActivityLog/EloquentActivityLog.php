<?php

namespace App\Infrastructure\ActivityLogs;

use App\Domain\ActivityLogs\ActivityLogsRepository;
use App\Domain\ActivityLogs\ActivityLogs;
use App\Infrastructure\ActivityLogs\ActivityLogsModel;
use Carbon\Carbon;

class EloquentActivityLogsRepository implements ActivityLogsRepository
{
    public function create(ActivityLogs $activityLogs): void
    {
        $model = new ActivityLogsModel();
        $model->admin_id = $activityLogs->getAdminId();
        $model->action = $activityLogs->getAction();
        $model->description = $activityLogs->getDescription();
        $model->ip_address = $activityLogs->getIpAddress();
        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();
        $model->save();
    }

    public function findByAdminId(int $adminId): array  
    {
        $logs = ActivityLogsModel::where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $logs->map(fn($model) => $this->toEntity($model))->all();
    }

    public function findAll(): array
    {
        return ActivityLogsModel::orderBy('created_at', 'desc')
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->all();
    }

    private function toEntity($model): ActivityLogs
    {
        return new ActivityLogs(
            id: $model->id,
            admin_id: $model->admin_id,
            action: $model->action,
            description: $model->description,
            ip_address: $model->ip_address,
            created_at: $model->created_at,
            updated_at: $model->updated_at
        );
    }
}