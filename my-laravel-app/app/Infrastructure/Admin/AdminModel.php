<?php

namespace App\Infrastructure\Admin;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Infrastructure\Worker\WorkerModel;

class AdminModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    protected $fillable = ['id', 'name', 'username', 'password', 'role_id', 'image', 'deleted'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'password' => 'hashed', 
        'role_id' => 'integer', 
        'created_at' => 'datetime', 
        'updated_at' => 'datetime',
        'deleted' => 'boolean'
    ];
    public $timestamps = true;

    public function worker()
    {
        return $this->hasOne(WorkerModel::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function($user) {
            // If user is being marked as deleted
            if ($user->isDirty('deleted') && $user->deleted) {
                if ($user->worker) {
                    $user->worker->update(['deleted' => 1]);
                }
            }
            // If user is being restored
            if ($user->isDirty('deleted') && !$user->deleted) {
                if ($user->worker) {
                    $user->worker->update(['deleted' => 0]);
                }
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted', 1);
    }
}