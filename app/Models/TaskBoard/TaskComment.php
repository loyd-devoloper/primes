<?php

namespace App\Models\TaskBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    use HasFactory;

    protected $fillable = ['comment','like','files','task_id','id_number'];

    public function employeeInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id_number','id_number');
    }
}
