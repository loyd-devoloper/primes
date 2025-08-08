<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequestLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity',
        'id_number',
        'remarks',
        'location',
        'leave_request_id'
    ];


}
