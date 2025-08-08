<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RecruitmentPsbGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'job_id',
        'batch_id',
        'status',
        'applicant_id',
        'education',
        'education_total',
        'education_remarks',
        'training',
        'training_total',
        'training_remarks',
        'experience',
        'experience_total',
        'experience_remarks',
        'performance',
        'performance_type',
        'performance_total',
        'performance_remarks',
        'outstanding',
        'outstanding_a',
        'outstanding_a_remarks',
        'outstanding2_a',
        'outstanding2_a_remarks',
        'outstanding3_a',
        'outstanding3_a_remarks',
        'outstanding_b',
        'outstanding_b_remarks',
        'outstanding_c',
        'outstanding_c_remarks',
        'outstanding_d',
        'outstanding_d_remarks',
        'outstanding_e',
        'outstanding_e_remarks',
        'application_of_education',
        'application_of_education_a',
        'application_of_education_a_remarks',
        'application_of_education_b',
        'application_of_education_b_remarks',
        'l_and_d',
        'l_and_d_remarks',
        'we',
        'wst',
        'bei',
        'potential_total',
    ];

    public function applicantInfo()
    {
        return $this->hasOne(\App\Models\RecruitmetJobApplication::class,'application_code','applicant_id');
    }
    public function psbsInfo()
    {
        return $this->hasOne(\App\Models\RecruitmentJobPsb::class,'id_number','id_number');
    }
    public function psbInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }

    public function jobOtherInformation()
    {
        return $this->hasOne(\App\Models\RecruitmentJobOtherInfotmation::class,'batch_id','batch_id');
    }


}
