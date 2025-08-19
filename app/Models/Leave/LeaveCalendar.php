<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'startTime',
        'endTime',
        'display',
        'backgroundColor',
        'url',
        'title',
        'id_number',
        'type',
        'max_departure'
    ];
}
