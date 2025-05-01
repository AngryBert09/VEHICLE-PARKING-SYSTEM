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
        // Retrieve all parking records, sorted by check_out in descending order
        $parkings = Parking::orderBy('check_out', 'desc')->get();

        // Retrieve all parking lots, including their status and availability
        $parkingLots = ParkingLot::all();

        // Calculate the total amount from the Parking table
        $totalAmount = Parking::sum('total_amount');

        // Pass the sorted parkings, all parking lots, and the total amount to the view
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
