<?php

namespace App\Models\Leave;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveBulkDtr extends Model
{
    use HasFactory;

    protected $fillable = ['date','batch','id_number','dtr','type','group_id','user_name'];

    public function employee()
    {
        return $this->hasOne(User::class,'id_number','id_number');
    }


}
