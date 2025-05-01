<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{

    protected $table = 'vehicle_categories';

    protected $fillable = [
        'group_name',
        'status',
    ];


    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
