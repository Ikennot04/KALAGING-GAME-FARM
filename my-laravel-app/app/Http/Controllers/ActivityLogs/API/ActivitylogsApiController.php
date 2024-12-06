<?php

namespace App\Http\Controllers\ActivityLogs\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitylogsApiController extends Controller
{
  
    private ActivityLogRepository $activityLogRepository;

    public function __construct(ActivityLogRepository $activityLogRepository)
    {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function create(
        int $adminId,
        string $action,
        string $description,
        ?string $ipAddress
    ): void {
        $activityLog = new ActivityLog(
            id: null,
            admin_id: $adminId,
            action: $action,
            description: $description,
            ip_address: $ipAddress
        );

        $this->activityLogRepository->create($activityLog);
    }

    public function findByAdminId(int $adminId): array
    {
        return $this->activityLogRepository->findByAdminId($adminId);
    }

}
