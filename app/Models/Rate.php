<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    // Define the table name if it is not the plural form of the model
    protected $table = 'rates';

    // Define the fillable fields (columns) that can be mass-assigned
    protected $fillable = [
        'rate_name',
        'category_id',
        'type',
        'rate',
        'status',
    ];

    // If you want to allow timestamps (created_at, updated_at) management by Eloquent
    public $timestamps = true;

    // You can also specify which attributes should be cast to specific data types
    protected $casts = [
        'rate' => 'decimal:2', // Cast rate as decimal with 2 decimal places
        'status' => 'string', // Active can be cast to a string, to handle it as either 'active' or 'inactive'
    ];

    // In the Rate model
    public function vehicleCategory()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

}
