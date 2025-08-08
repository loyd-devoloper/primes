<?php

namespace App\Models\Leave;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBulkCto extends Model
{
    use HasFactory;

    protected $fillable = [
        'effective_date',
        'expired_date',
        'status',
        'points',
        'subject',
        'employees',
        'attachment',
        'employee_leave_id',
        'id_number'
    ];

    public function employeeInfo()
    {
        return $this->hasOne(User::class, 'id_number', 'id_number');
    }
}
