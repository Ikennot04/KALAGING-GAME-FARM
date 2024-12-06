<?php

namespace App\Domain\Admin;

class Admin
{
    private ?int $id;
    
    private ?string $name;
    private ?string $username;
    private ?string $apiToken;
    private ?String $password;
    private ?string $created_at;
    private ?string $updated_at;

    public function __construct(
        ?int $id = null,
        
        ?string $name = null,
        ?string $username = null,
        ?string $password = null,
        ?string $apiToken = null,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->apiToken = $apiToken;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'apiToken' => $this->apiToken,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
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

    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getApiToken()
    {
        return $this->apiToken;
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