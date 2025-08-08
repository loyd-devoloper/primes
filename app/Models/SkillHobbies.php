<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillHobbies extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'skills_hobbies',
        'recognition',
        'membership_organization',
        'type',
    ];
}
