<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    // Define the fillable attributes

    protected $table = 'parking';

    protected $fillable = [
        'parking_code',
        'user_id',
        'rate_id',
        'slot_id',
        'vehicle_id',
        'check_in',
        'check_out',
        'vehicle_type',
        'rate_name',
        'rate',
        'slot',
        'total_time',
        'total_amount',
        'paid_status',
    ];
}
