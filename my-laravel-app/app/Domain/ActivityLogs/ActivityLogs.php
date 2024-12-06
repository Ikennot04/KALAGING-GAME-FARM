<?php

namespace App\Domain\ActivityLog;

class ActivityLog
{
    public function __construct(
        private ?int $id,
        private int $admin_id,
        private string $action,
        private string $description,
        private ?string $ip_address,
        private ?string $created_at = null,
        private ?string $updated_at = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminId(): int
    {
        return $this->admin_id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
}