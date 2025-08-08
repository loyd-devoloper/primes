<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'device',
        'device_version',
        'device_type',
        'browser',
        'browser_version',
        'ip',
        'activity',
        'type',
        'description',

    ];
}
