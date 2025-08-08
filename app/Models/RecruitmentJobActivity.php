<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentJobActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity',
        'message',
        'type',
        'id_number',
        'job_id',
    ];
}
