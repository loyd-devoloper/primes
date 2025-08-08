<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentJobBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'batch_name',
        'status',
        'closing_date',
        'posting_date',
        'batch_id',
        'car_file',
        'notification_letter',
        'hired_applicant_id'
    ];

    public function jobInfo()
    {
        return $this->hasOne(\App\Models\Recruitment_Job::class,'job_id','job_id');
    }
    public function jobOtherInformation()
    {
        return $this->hasOne(\App\Models\RecruitmentJobOtherInfotmation::class,'batch_id','batch_id');
    }
    public function monitoring()
    {
        return $this->hasOne(\App\Models\RecruitmentMonitoring::class,'batch_id','batch_id');
    }
    public function hiredInfo()
    {
        return $this->hasOne(\App\Models\RecruitmetJobApplication::class,'application_code','hired_applicant_id');
    }
}
