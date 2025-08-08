<?php

namespace App\Models\TaskBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskBoardItem extends Model
{
    use HasFactory;
    protected $fillable = ['title','order','group_id','description','files','tags'];

    public function comments()
    {
        return $this->hasMany(\App\Models\TaskBoard\TaskComment::class,'task_id','id')->orderBy('id','desc');
    }
}
