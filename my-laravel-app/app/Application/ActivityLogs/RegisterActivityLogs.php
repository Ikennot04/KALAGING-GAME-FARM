<?php

namespace App\Application\ActivityLogs;

use App\Domain\ActivityLogs\ActivityLogsRepository;
use App\Domain\ActivityLogs\ActivityLogs;

class RegisterActivityLogs
{
    private ActivityLogsRepository $activityLogsRepository;

    public function __construct(ActivityLogsRepository $activityLogsRepository)
    {
        $this->activityLogsRepository = $activityLogsRepository;
    }

    public function create(
        int $adminId,
        string $action,
        string $description,
        ?string $ipAddress
    ): void {
        $activityLog = new ActivityLogs(
            id: null,
            admin_id: $adminId,
            action: $action,
            description: $description,
            ip_address: $ipAddress,
            created_at: null,
            updated_at: null
        );

        $this->activityLogsRepository->create($activityLog);
    }

    public function findByAdminId(int $adminId): array
    {
        return $this->activityLogsRepository->findByAdminId($adminId);
    }
}