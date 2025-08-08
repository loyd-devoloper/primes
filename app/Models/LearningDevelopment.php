<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningDevelopment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'title',
        'from',
        'to',
        'number_hours',
        'type_ld',
        'conducted_by',
        'attachment',
    ];
}
