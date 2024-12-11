<?php

namespace App\Domain\Bird;

use Illuminate\Support\Facades\Storage;

class Bird
{
    private ?int $id;
    private ?string $owner;
    private ?string $image;
    private ?string $handler;
    private ?string $created_at;
    private ?string $updated_at;
    private ?string $breed;

    public function __construct(
        ?int $id = null,
        ?string $owner = null,
        ?string $handler = null,
        ?string $image = null,
        ?string $breed = null,
        ?string $created_at = null,
        ?string $updated_at = null,
    ) {
        $this->id = $id;
        $this->owner = $owner;
        $this->handler = $handler;
        $this->image = $image;
        $this->breed = $breed;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'breed' => $this->getBreed(),
            'owner' => $this->getOwner(),
            'handler' => $this->getHandler(),
            'image' => $this->getImage(),
            'created_at' => $this->Created(),
            'updated_at' => $this->Updated()
        ];
    }
    public function getId()
    {
        return $this->id;
    }

    public function getOwner()
    {
        return $this->owner;
    }
    public function getHandler()
    {
        return $this->handler;
    }
    public function getBreed()
    {
        return $this->breed;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function Created()
    {
        return $this->created_at;
    }
    public function Updated()
    {
        return $this->updated_at;
    }
    public function getImageUrl()
    {
        return $this->image 
            ? Storage::disk('public')->url('images/' . $this->image)
            : Storage::disk('public')->url('images/default.jpg');
    }
}