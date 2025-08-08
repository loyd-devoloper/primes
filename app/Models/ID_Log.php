<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID_Log extends Model
{
    use HasFactory;

    protected $fillable = ['photo','id_number'];
}
