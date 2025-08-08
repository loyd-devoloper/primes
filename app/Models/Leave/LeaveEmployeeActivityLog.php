<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEmployeeActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity',
        'remarks',
        'location',
        'link',
        'id_number',
        'employee_leave_id',
        'type',
    ];
}
