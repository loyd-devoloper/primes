<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicationFileComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'comment',
        'filename',
        'id_number'
    ];

    public function employeeInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }
}
