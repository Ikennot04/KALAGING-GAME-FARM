<?php

namespace App\Infrastructure\ActivityLog;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Admin\AdminModel;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'admin_id',
        'action',
        'description',
        'ip_address'
    ];

    public function admin()
    {
        return $this->belongsTo(AdminModel::class, 'admin_id', 'id');
    }
}