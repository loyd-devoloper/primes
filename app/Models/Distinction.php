<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distinction extends Model
{
    use HasFactory;

    protected $fillable = ['distinction','id_number','year','file','agency'];
}
