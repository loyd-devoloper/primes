<?php

namespace App\Models\TaskBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskBoardGroup extends Model
{
    use HasFactory;

    protected $fillable = ['label','task_id','color','pin'];

    public function tasks()
    {
        return $this->hasMany(\App\Models\TaskBoard\TaskBoardItem::class,'group_id','id');
    }
}
