<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrailsUserLogs extends Model
{
    use SoftDeletes;

    protected $table = 'trails_user_logs';

    protected $fillable = [
        'users_id',
        'action',
        'ip_address'
    ];
}
