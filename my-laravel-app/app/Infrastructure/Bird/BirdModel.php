<?php

namespace App\Infrastructure\Bird;

use Illuminate\Database\Eloquent\Model;

class BirdModel extends Model
{
    protected $table = 'birds';
    protected $fillable = ['id', 'owner', 'breed', 'handler', 'image', 'created_at', 'updated_at',];
}