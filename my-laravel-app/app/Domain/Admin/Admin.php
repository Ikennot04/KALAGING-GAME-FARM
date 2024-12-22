<?php

namespace App\Domain\Admin;

use Carbon\Carbon;

class Admin
{
    private ?int $id;
    private ?string $name;
    private ?string $username;
    private ?string $password;
    private ?int $role_id;
    private ?string $image;
    private ?bool $deleted;

    private ?Carbon $created_at;
    private ?Carbon $updated_at;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $username = null,
        ?string $password = null,
        ?int $role_id = null,
        ?string $image = null,
        $created_at = null,
        $updated_at = null,
        ?bool $deleted = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->role_id = $role_id;
        $this->image = $image;
        $this->deleted = $deleted;
        $this->created_at = $created_at ? Carbon::parse($created_at) : null;
        $this->updated_at = $updated_at ? Carbon::parse($updated_at) : null;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'username' => $this->getUsername(),
            'role_id' => $this->getRoleId(),
            'image' => $this->getImage(),
            'deleted' => $this->isDeleted(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    // Add magic method for property access in views
    public function __get($property)
    {
        return match($property) {
            'id' => $this->getId(),
            'name' => $this->getName(),
            'username' => $this->getUsername(),
            'role_id' => $this->getRoleId(),
            'image' => $this->getImage(),
            'deleted' => $this->isDeleted(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            default => null
        };
    }
}