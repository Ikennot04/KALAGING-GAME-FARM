<?php

namespace App\Domain\Worker;

use Illuminate\Support\Facades\Storage;
class Worker
{
    private ?int $id;
    private ?string $name;
    private ?string $position;
    private ?string $image;
    private ?string $created_at;
    private ?string $updated_at;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $position = null,
        ?string $image = null,
        ?string $created_at = null,
        ?string $updated_at = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPosition()
    {
        return $this->position;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

}

