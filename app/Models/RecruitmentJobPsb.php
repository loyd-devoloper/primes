<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentJobPsb extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_number",
        "otherinformation_id",
        'batch_id',
        'job_id'
    ];

    public function otherInfo()
    {
        return $this->hasOne(\App\Models\RecruitmentJobOtherInfotmation::class,'id','otherinformation_id');
    }
    public function psbOtherInformation()
    {
        return $this->hasOne(\App\Models\RecruitmentJobOtherInfotmation::class,'batch_id','batch_id');
    }
    public function psbInformation()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }

    public function applicantGrade()
    {
        return $this->hasMany(\App\Models\RecruitmentPsbGrade::class,'id_number','id_number');
    }

    public function applicants()
    {
        return $this->hasMany(\App\Models\RecruitmetJobApplication::class,'batch_id','batch_id');
    }
    public function jobInfos()
    {
        return $this->belongsTo(\App\Models\Recruitment_Job::class,'job_id','job_id');
    }
}
