<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruitment_Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_title',
        'salary_grade',
        'status_of_appointment',
        'place_of_assignment',
        // 'closing_date',//
        'status_of_hiring',
        'plantilla_item',
        'description',
        'application_code',
        'education',
        'training',
        'experience',
        'eligibility',
        'car_file'

    ];
    public function batchInfo()
    {
        return $this->hasOne(\App\Models\RecruitmentJobBatch::class,'job_id','job_id');
    }
    public function checkFile()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class, 'job_id', 'job_id');
    }
    public function allApplicant()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class, 'job_id', 'job_id')->select('job_id');
    }
    public function validator()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class, 'job_id', 'job_id');
    }
    public function qualified()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class, 'job_id', 'job_id');
    }
    public function notqualified()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class, 'job_id', 'job_id');
    }


}
