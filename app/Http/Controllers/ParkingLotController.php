<?php

namespace App\Http\Controllers;

use App\Models\ParkingLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\VehicleCategory;

class ParkingLotController extends Controller
{
    // Display a listing of the parking slots
    public function index()
    {
        $parkingSlots = ParkingLot::all(); // Adjust the number of items per page
        return view('admin.parking_lot.index', compact('parkingSlots'));  // Pass data to the view
    }

    // Show the form for creating a new parking slot
    public function create()
    {
        $vehicleCategories = VehicleCategory::all();

        return view('admin.parking_lot.create', compact('vehicleCategories'));
    }

    // Store a newly created parking slot in the database
    public function store(Request $request)
    {
        try {
            // Log incoming request data for debugging
            Log::info('Store Parking Lot Request', $request->all());

            // Validate the incoming request
            $validated = $request->validate([
                'slot_name' => 'required|string|unique:parking_lot,slot_name|max:255',
                'status' => 'required|in:active,inactive',
                'category' => 'required|exists:vehicle_categories,id', // Ensure category exists
            ]);

            // Fetch the selected vehicle category
            $category = VehicleCategory::findOrFail($validated['category']);

            // Create a new parking lot record
            $parkingLot = new ParkingLot();
            $parkingLot->slot_name = $validated['slot_name'];
            $parkingLot->status = $validated['status'];
            $parkingLot->vehicle_type = $category->group_name; // Store the name of the category
            $parkingLot->availability = 'Available'; // Default availability to 'Available'

            // Save the new parking lot record
            $parkingLot->save();

            // Log success message
            Log::info('Parking Lot Created Successfully', [
                'slot_name' => $parkingLot->slot_name,
                'status' => $parkingLot->status,
                'vehicle_type' => $category->group_name,
            ]);

            // Redirect with success message
            return redirect()->route('parking-lots.index')->with('success', 'Parking lot created successfully.');
        } catch (\Exception $e) {
            // Log error details
            Log::error('Error Creating Parking Lot', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            // Redirect back with error message
            return redirect()->back()->withErrors(['error' => 'Failed to create parking lot. Please try again.']);
        }
    }


    // Show the form for editing the specified parking slot
    public function edit(ParkingLot $parkingLot)
    {
        return view('admin.parking_lot.edit', compact('parkingLot'));
    }

    // Update the specified parking slot in the database
    public function update(Request $request, ParkingLot $parkingLot)
    {
        Log::debug('Raw Request Data:', $request->all());

        $validated = $request->validate([
            'slot_name' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'availability' => 'nullable|in:Occupied,Available,Reserved',
        ]);

        Log::debug('Validated Data for Update:', $validated);

        try {
            $updateResult = $parkingLot->update($validated);
            Log::debug('Update Result:', ['result' => $updateResult]);

            return redirect()
                ->route('parking-lots.index')
                ->with('success', 'Parking slot updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating Parking Slot:', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('parking-lots.index')
                ->with('error', 'Failed to update the parking slot. Please try again.');
        }
    }


    // Remove the specified parking slot from the database
    public function destroy(ParkingLot $parkingLot)
    {
        $parkingLot->delete();

        // Redirect back with a success message
        return redirect()->route('parking-lots.index')->with('success', 'Parking slot deleted successfully!');
    }
}
