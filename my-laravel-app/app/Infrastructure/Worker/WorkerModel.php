<?php

namespace App\Infrastructure\Worker;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Admin\AdminModel;
use App\Infrastructure\Bird\BirdModel;

class WorkerModel extends Model
{
    protected $table = 'workers';
    
    protected $fillable = [
        'name',
        'position',
        'image',
        'user_id',
        'deleted'
    ];

    protected $attributes = [
        'deleted' => 0
    ];

    // Relationship with User/Admin
    public function user()
    {
        return $this->belongsTo(AdminModel::class, 'user_id');
    }

    // Birds handled by this worker
    public function birds()
    {
        return $this->hasMany(BirdModel::class, 'handler', 'name');
    }

    // Getters and Setters
    public function setUserId(?int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getUserId(): ?int
    {
        return $this->attributes['user_id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getPosition(): string
    {
        return $this->attributes['position'];
    }

    public function setPosition(string $position): void
    {
        $this->attributes['position'] = $position;
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    // Scopes for active/archived workers
    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted', 1);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function($worker) {
            if ($worker->isDirty('deleted') && $worker->deleted) {
                if ($worker->user) {
                    $worker->user->update(['deleted' => 1]);
                }
            }
            if ($worker->isDirty('deleted') && !$worker->deleted) {
                if ($worker->user) {
                    $worker->user->update(['deleted' => 0]);
                }
            }
        });
    }
}