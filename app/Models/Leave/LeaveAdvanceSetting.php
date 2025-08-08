<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveAdvanceSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'min1', 'min2', 'min3', 'min4', 'min5', 'min6', 'min7', 'min8', 'min9', 'min10',
        'min11', 'min12', 'min13', 'min14', 'min15', 'min16', 'min17', 'min18', 'min19', 'min20',
        'min21', 'min22', 'min23', 'min24', 'min25', 'min26', 'min27', 'min28', 'min29', 'min30',
        'min31', 'min32', 'min33', 'min34', 'min35', 'min36', 'min37', 'min38', 'min39', 'min40',
        'min41', 'min42', 'min43', 'min44', 'min45', 'min46', 'min47', 'min48', 'min49', 'min50',
        'min51', 'min52', 'min53', 'min54', 'min55', 'min56', 'min57', 'min58', 'min59', 'min60',
        'hours1', 'hours2', 'hours3', 'hours4', 'hours5', 'hours6', 'hours7', 'hours8', 'hours9', 'hours10',
        'month1', 'month2', 'month3', 'month4', 'month5', 'month6', 'month7', 'month8', 'month9', 'month10',
        'month11', 'month12',
        'days1', 'days2', 'days3', 'days4', 'days5', 'days6', 'days7', 'days8', 'days9', 'days10',
        'days11', 'days12', 'days13', 'days14', 'days15', 'days16', 'days17', 'days18', 'days19', 'days20',
        'days21', 'days22', 'days23', 'days24', 'days25', 'days26', 'days27', 'days28', 'days29', 'days30/31',
        'days31'
    ];
}
