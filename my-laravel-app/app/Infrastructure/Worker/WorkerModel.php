<?php

namespace App\Infrastructure\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerModel extends Model
{
    protected $table = 'workers';
    protected $fillable = ['id', 'name', 'position', 'image', 'created_at', 'updated_at', 'deleted'];
    protected $casts = ['deleted' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted', 1);
    }
}