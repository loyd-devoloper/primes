<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity',
        'message',
        'type',
        'id_number',
        'applicant_id',
    ];

    public function employeeInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }
}
