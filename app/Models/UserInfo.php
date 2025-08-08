<?php

namespace App\Models;


use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'division_code',
        'lname',
        'fname',
        'mname',
        'name_extension',
        'birth_date',
        'place_birth',
        'citizenship',
        'sex',
        'civil_status',
        'height',
        'weight',
        'blood_type',
        'gsis_no',
        'pag_ibig_no',
        'philhealth_no',
        'sss_no',
        'tin_no',
        'agency_employee_no',
        'telephone_no',
        'mobile_no',
        'contact_person_name',
        'contact_person_address',
        'contact_person_number',
    ];

    // cast
    protected function lname(): Attribute
{
    return Attribute::make(
        get: fn(?string $value) => $value !== null ? Crypt::decryptString($value) : null,
    );
}

  protected function fname(): Attribute
    {
        return Attribute::make(
        get: fn(?string $value) => $value !== null ? Crypt::decryptString($value) : null,
    );
    }

      protected function mname(): Attribute
    {
        return Attribute::make(
        get: fn(?string $value) => $value !== null ? Crypt::decryptString($value) : null,
    );
    }


    public function userProfile()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }
    public function skillHobbies()
    {
        return $this->hasMany(SkillHobbies::class,'id_number','id_number');
    }
    public function learningAndDevelopment()
    {
        return $this->hasMany(LearningDevelopment::class,'id_number','id_number');
    }
    public function voluntaryAndInvolvement()
    {
        return $this->hasMany(VoluntaryWork::class,'id_number','id_number');
    }
    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class,'id_number','id_number');
    }
    public function civilServiceEligibility()
    {
        return $this->hasMany(Eligibility::class,'id_number','id_number');
    }
    public function educationalBackground()
    {
        return $this->hasMany(EducationBackground::class,'id_number','id_number');
    }
    public function familyBackground()
    {
        return $this->hasOne(FamilyBackground::class,'id_number','id_number');
    }
    public function familyBackgroundChildren()
    {
        return $this->hasMany(Children::class,'id_number','id_number');
    }
    public function child()
    {
        return $this->hasOne(Children::class,'id_number','id_number');
    }
    public function otherInfo()
    {
        return $this->hasOne(OtherInfo::class,'id_number','id_number');
    }
}
