<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFeedback extends Model
{
    use HasFactory;

    protected $fillable = ['message','image','status','id_number','fix_by'];

    public function employeeInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number')->select('id_number','name');
    }
    public function fixBy()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','fix_by')->select('id_number','name');
    }
}
