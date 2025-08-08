<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID_Attribute extends Model
{
    use HasFactory;

    protected $table = 'tbl_id_attribute';

    protected $fillable = ['id_template','attribute'];
}
