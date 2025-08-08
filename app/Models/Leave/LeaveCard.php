<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'particulars',
        'start_date',
        'remarks',
        'days',
        'mins',
        'hours',
        'type',
        'w_pay',
        'w_o_pay',
        'sl_earn',
        'vl_earn',
        'sl_balance',
        'vl_balance',
        'cto_balance',
        'request_id',
        'id_number',
    ];
}
