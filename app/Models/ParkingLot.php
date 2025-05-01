<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'parking_lot';

    // The attributes that are mass assignable
    protected $fillable = [
        'slot_name',
        'status',
        'vehicle_type',
        'availability',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [];

    public function vehicleCategory()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id'); // or whatever the foreign key is
    }
}
