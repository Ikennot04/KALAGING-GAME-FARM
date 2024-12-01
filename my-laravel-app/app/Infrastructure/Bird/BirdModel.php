<?php

namespace App\Infrastructure\Bird;

use Illuminate\Database\Eloquent\Model;

class BirdModel extends Model
{
    protected $table = 'birds';
    protected $fillable = ['id', 'owner', 'breed', 'handler', 'image', 'created_at', 'updated_at', 'deleted'];
    protected $casts = ['deleted' => 'boolean'];
    public function scopeActive($query)
    {
        return $query->where('deleted', false);
    }
    public function scopeArchived($query)
    {
        return $query->where('deleted', true);
    }
}
