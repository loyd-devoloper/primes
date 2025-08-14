<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBulkDtrGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function dtr()
    {
        return $this->hasMany(LeaveBulkDtr::class,'group_id','id');
    }
}
