<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentJobOtherInfotmation extends Model
{
    use HasFactory;
    protected $fillable = [
        "batch_id",
        "job_id",
        "venue",
        "initial_evaluation",
        "open_ranking",
        "exam",
        "interview",
        "type",
        "category",
        "min_requirements_education",
        "min_requirements_training",
        "min_requirements_experience",
    ];

    public function jobDetails()
    {
        return $this->hasOne(\App\Models\Recruitment_Job::class,'job_id','job_id');
    }
    public function batchDetails()
    {
        return $this->hasOne(\App\Models\RecruitmentJobBatch::class,'batch_id','batch_id');
    }
    public function psbs()
    {
        return $this->hasMany(\App\Models\RecruitmentJobPsb::class,'otherinformation_id','id');
    }
    public function applicants()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class,'batch_id','batch_id');
    }

}
