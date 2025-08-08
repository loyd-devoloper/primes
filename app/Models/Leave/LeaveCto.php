<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCto extends Model
{
    use HasFactory;

    protected $fillable = [
        'effective_date',
        'expired_date',
        'status',
        'points',
        'subject',
        'id_number',
        'attachment',
        'employee_leave_id',
        'bulk_id'
    ];
}
