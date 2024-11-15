<?php

namespace App\Domain\Bird;

class Bird {
    private ?int $id;
    
    private ?string $owner;
    private ?string $image;
    private ?float $handler;
    private ?string $created_at;
    private ?string $updated_at;
    private ?string $breed;

    public function __construct(
        ?int $id = null,
        
        ?string $owner = null,
        ?float $handler = null,
        ?string $image = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?string $breed = null,
        ) {
            $this->id = $id;
            
            $this->owner = $owner;
            $this->handler = $handler;
            $this->image = $image;
            $this->created_at = $created_at;
            $this->updated_at = $updated_at;
            $this->breed = $breed;
        }
        public function toArray()
    {
        return [
            'id' => $this->id,
            
            'name' => $this->owner,
            'price' => $this->handler,
            'category' => $this->breed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image' => $this->image,
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

}