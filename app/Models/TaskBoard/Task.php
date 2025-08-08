<?php

namespace App\Models\TaskBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name','status','division_name','id_number','pin'];

    public function groups()
    {
        return $this->hasMany(\App\Models\TaskBoard\TaskBoardGroup::class,'task_id','id');
    }
}
