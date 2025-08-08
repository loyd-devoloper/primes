<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['sl','vl','fl','spl','id_number','e_sign','year','current_month','status'];
}
