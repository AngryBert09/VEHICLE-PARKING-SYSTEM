<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\ParkingLot;
use App\Models\VehicleCategory;

class DashboardController extends Controller
{

    public function index()
    {
        // Eager load only necessary relationships (if any), and select only needed columns
        $parkings = Parking::latest('check_out')->select('id', 'vehicle_plate', 'check_in', 'check_out', 'total_amount')->get();

        // Consider selecting only the necessary columns to reduce query load
        $parkingLots = ParkingLot::select('id', 'name', 'status', 'availability')->get();

        // Aggregate total_amount directly without loading all records
        $totalAmount = Parking::sum('total_amount');

        return view('admin.dashboard', compact('parkings', 'parkingLots', 'totalAmount'));
    }




    public function indexUser()
    {
        // Retrieve all parking records, sorted by check_out in descending order

        $parkings = Parking::all();
        $parkingSlots = ParkingLot::all();
        $vehicles = VehicleCategory::all();

        // Pass the sorted parkings to the view
        return view('users.dashboard', compact('parkings', 'parkingSlots', 'vehicles'));
    }
}
