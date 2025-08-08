<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeCode extends Model
{
    use HasFactory;

    protected $fillable = ['division_code','division_name','division_short_name','fd_chief','chief_designation','division_id','office_level_id','id_number'];

    protected $table = 'tbl_fd';
}
