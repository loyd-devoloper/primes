<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveEmployeeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'type_of_leave',
        'others',
        'date',
        'type_of_process',
        'original_file',
        'signed_file',
        'e_sign',
        'chief_id',
        'chief_type',
        'rd_id',
        'rd_type',
        'head_id',
        'disapproved_remarks_head',
        'disapproved_remarks_chief',
        'disapproved_remarks_rd',
        'head_status',
        'chief_status',
        'rd_status',
        'status',
        'subject_title',
        'location',
        'code',
        'days',
        'paid_days',
        'notpaid_days',
        'sl',
        'vl',
        'fl',
        'spl',
        'cto',
        'archived',
    ];
    public function employeeInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number')->select('id_number','name');
    }
    public function leavePointLatest()
    {
        return $this->hasOne(\App\Models\LeaveEmployee::class,'id_number','id_number')->whereYear('created_at',Carbon::now())->latest();
    }
    public function userInfo()
    {
        return $this->hasOne(\App\Models\UserInfo::class,'id_number','id_number')->select('id_number','fname','mname','lname');
    }

    public function workExperience()
    {
        return $this->hasOne(WorkExperience::class,'id_number','id_number')->where('to','PRESENT')->orderBy('from','desc');
    }
    public function chiefInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','chief_id')->select('id_number','name');
    }

    public function headInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','head_id')->select('id_number','name');
    }

    public function rdInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','rd_id')->select('id_number','name');
    }
}
