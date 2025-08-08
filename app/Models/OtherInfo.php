<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'no34_a',
        'no34_b',
        'no34_b_yes_details',
        'no35_a',
        'no35_a_yes_details',
        'no35_b',
        'no35_b_date_filed',
        'no35_b_case_status',
        'no36_a',
        'no36_a_yes_details',
        'no37_a',
        'no37_a_yes_details',
        'no38_a',
        'no38_a_yes_details',
        'no38_b',
        'no38_b_yes_details',
        'no39_a',
        'no39_a_yes_details',
        'no40_a',
        'no40_a_yes_details',
        'no40_b',
        'no40_b_yes_details',
        'no40_c',
        'no40_c_yes_details',
        'c_ref1_name',
        'c_ref1_address',
        'c_ref1_tel',
        'c_ref2_name',
        'c_ref2_address',
        'c_ref2_tel',
        'c_ref3_name',
        'c_ref3_address',
        'c_ref3_tel',
        'e_sig',
    ];
}
