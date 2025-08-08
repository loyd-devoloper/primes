<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentMonitoringFileUpload extends Model
{
    use HasFactory;

    protected $fillable = [

        'file',
        'job_id',
        'batch_id'
    ];
}
