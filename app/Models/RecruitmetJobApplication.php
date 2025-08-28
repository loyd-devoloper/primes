<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecruitmetJobApplication extends Model
{
    use HasFactory;


    protected $fillable = [
        'application_code',
        'fname',
        'mname',
        'lname',
        'religion',
        'disability',
        'ethnic_group',
        'batch_id',
        'email',
        'mobile_number',
        'address',
        'sex',
        'birthdate',
        'civil_status',
        'letter_of_intent',
        'letter_of_intent_status',
        'pds',
        'pds_status',
        'prc',
        'prc_status',
        // 'eligibility',
        // 'eligibility_status',
        'tor',
        'tor_status',
        'training_attended',
        'training_attended_status',
        'certificate_of_employment',
        'certificate_of_employment_status',
        'latest_appointment',
        'latest_appointment_status',
        'performance_rating',
        'performance_rating_status',
        'cav',
        'cav_status',
        'awards_recognition',
        'research_innovation',
        'membership_in_national',
        'resource_speakership',
        'neap',
        'application_of_education',
        'l_and_d',
        'movs_status',
        'job_id',
        'application_status',
        'ies_file',
        'neap_status',
        'old_job_id',
        'copy',
        'old_id',
        'old_batch_id'

    ];
    // cast
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Crypt::decryptString($value),
        );
    }
    protected function mobileNumber(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Crypt::decryptString($value),
        );
    }
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Crypt::decryptString($value),
        );
    }

    public function comments()
    {
        return $this->hasMany(RecruitmentApplicationFileComment::class, 'application_id', 'id')->orderBy('id', 'desc');
    }
    public function activitiesEmail()
    {
        return $this->hasMany(\App\Models\ApplicantLog::class, 'applicant_id', 'id')->orderBy('id', 'desc')->where('type',10);
    }
    public function activities()
    {
        return $this->hasMany(\App\Models\ApplicantLog::class, 'applicant_id', 'id')->orderBy('id', 'desc');
    }

    public function jobInfo()
    {
        return $this->hasOne(\App\Models\Recruitment_Job::class, 'job_id', 'job_id');
    }

    public function eligibilityInfo()
    {
        return $this->hasOne(\App\Models\RecruitmentApplicationEligibility::class, 'application_code', 'application_code');
    }

    public function batchInfo()
    {
        return $this->hasOne(\App\Models\RecruitmentJobBatch::class, 'batch_id', 'batch_id');
    }

    public function jobOtherInformation()
    {
        return $this->hasOne(\App\Models\RecruitmentJobOtherInfotmation::class, 'batch_id','batch_id');
    }

    public function myGrade()
    {
        return $this->hasOne(\App\Models\RecruitmentPsbGrade::class, 'applicant_id','application_code');
    }
    public function assignPsb()
    {
        return $this->hasMany(\App\Models\RecruitmentJobPsb::class, 'batch_id','batch_id');
    }

    public function applicantGrades()
    {
        return $this->hasMany(\App\Models\RecruitmentPsbGrade::class, 'applicant_id','application_code');
    }

}
