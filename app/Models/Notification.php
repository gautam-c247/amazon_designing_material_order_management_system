<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['title', 'message', 'recipients', 'delivery_status', 'push_time', 'job_id'];

    protected $casts = [
        'recipients' => 'array',
        'push_time' => 'datetime',
    ];
}
