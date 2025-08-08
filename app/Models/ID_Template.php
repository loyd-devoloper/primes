<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID_Template extends Model
{
    use HasFactory;

    protected $table = 'tbl_id_template';
    protected $fillable = [
        'name',
        'front',
        'back',
        'status',
        'attribute'
    ];

    public function attributes()
    {
        return $this->hasOne(ID_Attribute::class, 'id_template');
    }
}
