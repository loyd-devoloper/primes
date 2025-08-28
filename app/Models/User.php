<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'employee_id',
        'fd_code',
        'user_type',
        'id_number',
        'status',
        'dtr_key'

    ];
    // ############################### Leave  ################################################
    public function leavePointLatestCto()
    {
        return $this->hasMany(\App\Models\Leave\LeaveCto::class,'id_number','id_number')->orderBy('expired_date','asc')->where('status',\App\Enums\CtoStatusEnum::ACTIVE->value);
    }
 public function leaveCard()
    {
        return $this->hasOne(\App\Models\Leave\LeaveCard::class,'id_number','id_number')->latest('start_date');
    }
    public function leavePointLatest()
    {
        return $this->hasOne(\App\Models\LeaveEmployee::class,'id_number','id_number')->latest();
    }
    public function leaveActivityLogs()
    {
        return $this->hasMany(\App\Models\Leave\LeaveEmployeeActivityLog::class,'employee_leave_id','id_number')->latest();
    }

    public function leaveEarn()
    {
        return $this->hasMany(\App\Models\Leave\LeaveEarn::class,'id_number','id_number')->orderBy('date','desc');
    }
    public function leaveRequests()
    {
        return $this->hasMany(\App\Models\LeaveEmployeeRequest::class,'id_number','id_number');
    }
    // id logs
    public function idLogs()
    {
        return $this->hasMany(ID_Log::class, 'id_number','id_number')->orderByDesc('id');
    }

    // ################################################### PSB ###############################################
    public function psb()
    {
        return $this->hasMany(\App\Models\RecruitmentJobPsb::class,'id_number','id_number');
    }
    public function comments()
    {
        return $this->HasMany(\App\Models\RecruitmentApplicationFileComment::class,'id_number','id_number');
    }
    public function user_fd_code()
    {
        return $this->hasOne(OfficeCode::class,'division_code','fd_code');
    }

    public function userInfo()
    {

        return $this->hasOne(UserInfo::class,'id_number','id_number');
    }
    public function skillHobbies()
    {
        return $this->hasMany(SkillHobbies::class,'id_number','id_number')->latest();
    }
    public function distinction()
    {
        return $this->hasMany(\App\Models\Distinction::class,'id_number','id_number')->orderBy('year','desc');
    }
    public function association()
    {
        return $this->hasMany(\App\Models\Association::class,'id_number','id_number')->orderBy('year','desc');
    }
    public function learningAndDevelopment()
    {
        $fiveYearsAgo = Carbon::today()->subYears(5);
        return $this->hasMany(LearningDevelopment::class,'id_number','id_number')->orderBy('to','desc') ->whereDate('to', '>=', $fiveYearsAgo);
        // return $this->hasMany(LearningDevelopment::class,'id_number','id_number')->orderBy('to','desc');
    }
    public function voluntaryAndInvolvement()
    {
        return $this->hasMany(VoluntaryWork::class,'id_number','id_number')->orderBy('to','desc');
    }
    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class,'id_number','id_number')->orderBy('to','desc')->limit(26);
    }
    public function workExperiencefirst()
    {
        return $this->hasOne(WorkExperience::class,'id_number','id_number')->orderBy('to','desc');
    }
    public function workExperienceCurrent()
    {
        return $this->hasOne(WorkExperience::class,'id_number','id_number')->where('to','PRESENT')->orderBy('from','desc');
    }
    public function civilServiceEligibility()
    {
        return $this->hasMany(Eligibility::class,'id_number','id_number')->orderByDesc('date_examination')->limit(7);
    }
    public function educationalBackground()
    {
        return $this->hasMany(EducationBackground::class,'id_number','id_number')->orderByDesc('to');
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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


    protected $casts = [
        'email_verified_at' => 'datetime',
        'same_as_permanent' => 'boolean',
    ];
}
