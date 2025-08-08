<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBulkDtr extends Model
{
    use HasFactory;

    protected $fillable = ['date','batch','id_number','dtr','type'];
}
