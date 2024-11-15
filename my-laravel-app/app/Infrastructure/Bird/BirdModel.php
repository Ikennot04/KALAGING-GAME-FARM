<?php

namespace App\Domain\Infrastructure\Bird;

class BirdModel extends Model
{
    protected $table = 'birds';
    protected $fillable = ['id', 'owner', 'breed','handler', 'image', 'created_at', 'updated_at',];

    
}