<?php

namespace App\Domain\ActivityLogs;

interface ActivityLogsRepository
{
    public function create(ActivityLogs $activityLogs): void;
    public function findByAdminId(int $adminId): array;
    public function findAll(): array;
}