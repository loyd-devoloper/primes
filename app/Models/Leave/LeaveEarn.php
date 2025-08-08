<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEarn extends Model
{
    use HasFactory;

    protected $fillable = ['status','date','id_number'];
}
