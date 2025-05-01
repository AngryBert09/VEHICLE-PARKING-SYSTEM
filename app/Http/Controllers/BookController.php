<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingLot;
use App\Models\VehicleCategory;
use App\Models\Rate;
use App\Models\Parking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all parking slots
        $parkingSlots = ParkingLot::all();
        $vehicleCategories = VehicleCategory::all();
        $rates = Rate::all();


        // Get all parking records, but only if there is a 'user_id' or use a relationship
        $parkings = Parking::with('user')->get(); // Assuming you have a 'user' relationship on Parking

        // Alternatively, you can fetch only relevant parking records if needed (like active or occupied ones):
        // $parkings = Parking::where('availability', 'occupied')->with('user')->get();

        // Pass the data to the view
        return view('users.dashboard', compact('parkingSlots', 'parkings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $vehicleCategories = VehicleCategory::all();
        $rates = Rate::all();
        $parkingSlots = ParkingLot::all();
        return view('bookings.create', compact('vehicleCategories', 'rates', 'parkingSlots')); // Return the create form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        Log::debug('Raw Request Data:', $request->all());

        // Validate the request
        $validated = $request->validate([
            'slot_id' => 'required|exists:parking_lot,id',            // Validate that the slot exists in the parking_lots table
            'vehicle_id' => 'nullable', // Validate that the selected category exists in the vehicle_categories table
            'rate_id' => 'nullable|exists:rates,id',                // Validate that the selected rate exists in the rates table
        ]);

        // Get the selected category's details


        // Get the selected rate's details
        $slot = ParkingLot::find($validated['slot_id']); // Fetch the parking slot based on the slot_id


        // Create the parking record
        try {
            // Generate a unique parking code
            $parkingCode = 'PA-' . strtoupper(Str::random(8));

            // Ensure the parking code is unique
            while (Parking::where('parking_code', $parkingCode)->exists()) {
                $parkingCode = 'PA-' . strtoupper(Str::random(8));
            }

            // Set the current time for check_in
            $validated['check_in'] = now();
            $validated['slot'] = $slot->slot_name;

            // Add the generated parking code to the validated data
            $validated['parking_code'] = $parkingCode;

            // Set the default 'paid_status' to 'unpaid' if it's not provided
            $validated['paid_status'] = 'unpaid';

            // Store the rate_name and rate based on the selected rate
            $validated['rate_name'] = 'UNAVAILABLE';
            $validated['rate'] = 0;

            // Store the rate_id explicitly
            $validated['rate_id'] = 0;

            // Store the category_name based on the selected category
            $validated['vehicle_type'] = 'For Verification';

            // Store the slot_id explicitly
            $validated['slot_id'] = $slot->id;

            // Store the vehicle_id
            $validated['vehicle_id'] = 0;

            $validated['user_id'] = Auth::id();

            // Update the parking slot's availability to 'occupied'
            $slot->availability = 'reserved';
            $slot->save(); // Save the changes to the parking slot

            // Store the parking record with the slot_id
            Parking::create($validated);

            // Redirect back with success message
            return redirect()->route('DashboardUser')->with('success', 'Parking record created successfully.');
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error creating parking record:', ['error_message' => $e->getMessage(), 'stack_trace' => $e->getTraceAsString()]);

            // Redirect back with error message
            return redirect()->route('DashboardUser')->with('error', 'Failed to create parking record.');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parking $parkings)
    {
        $vehicleCategories = VehicleCategory::all();
        $rates = Rate::all();
        $parkingSlots = ParkingLot::all();
        dd($parkings->user_id);
        return view('bookings.edit', compact('parkings', 'vehicleCategories', 'rates', 'parkingSlots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parking $parking)
    {
        // Log the incoming request data for debugging
        Log::debug('Raw Request Data:', ['data' => $request->all()]);

        // Validate the request with nullable fields
        $validated = $request->validate([
            'vehicle_id' => 'nullable|exists:vehicle_categories,id',
            'rate_id' => 'nullable|exists:rates,id',
            'slot_id' => 'nullable|exists:parking_lot,id',
            'rate_name' => 'nullable|string|max:100',
            'rate' => 'nullable|numeric|min:0',
            'total_time' => 'nullable|integer|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'paid_status' => 'nullable|in:paid,unpaid',
            'check_out' => 'nullable|date|after:check_in',
        ]);

        Log::debug('Validated Data:', ['validated' => $validated]);

        // Merge validated data with existing parking record values to retain any non-updated values
        $validated = array_merge([
            'vehicle_id' => $parking->vehicle_id,
            'rate_id' => $parking->rate_id,
            'slot_id' => $parking->slot_id,
            'vehicle_id' => $parking->vehicle_id,
            'slot' => $parking->slot,
            'rate_name' => $parking->rate_name,
            'rate' => $parking->rate,
            'total_time' => $parking->total_time,
            'total_amount' => $parking->total_amount,
            'paid_status' => $parking->paid_status,
            'check_out' => $parking->check_out,
            'check_in' => $parking->check_in,
            'parking_code' => $parking->parking_code,
        ], array_filter($validated, fn($value) => !is_null($value)));

        // Fetch associated models if required
        // Handle the vehicle_id change logic
        if (isset($validated['vehicle_id']) && $validated['vehicle_id'] !== $parking->vehicle_id) {
            // Log the incoming and current vehicle_ids for comparison
            Log::debug('Vehicle ID Comparison:', [
                'incoming_vehicle_id' => $validated['vehicle_id'],
                'current_vehicle_id' => $parking->vehicle_id
            ]);

            // Attempt to find the VehicleCategory by ID
            $category = VehicleCategory::find($validated['vehicle_id']);
            if ($category) {
                // Log the found category details
                $validated['vehicle_type'] = $category->group_name;
                Log::debug('Vehicle Category Found:', [
                    'category' => $category,
                    'vehicle_type' => $validated['vehicle_type']
                ]);
            } else {
                // Log an error if category is not found
                Log::error('Vehicle Category not found:', [
                    'vehicle_id' => $validated['vehicle_id']
                ]);
            }
        }


        if (isset($validated['rate_id'])) {
            $rate = Rate::find($validated['rate_id']);
            $validated['rate_name'] = $rate->rate_name;
            $validated['rate'] = $rate->rate;
            Log::debug('Rate Found:', ['rate' => $rate]);
        }


        Log::debug('Check-in Time:', ['check_in' => $validated['check_in']]);
        Log::debug('Parking Code:', ['parking_code' => $validated['parking_code']]);

        // Release the old slot (if applicable)
        if (isset($validated['slot_id']) && $validated['slot_id'] != $parking->slot_id) {
            // Release the old slot
            Log::debug('Attempting to release the old slot.', ['current_slot' => $parking->slot]);
            $oldSlot = ParkingLot::find($parking->slot_id);
            if ($oldSlot) {
                if ($oldSlot->availability !== 'available') {
                    $oldSlot->availability = 'available';
                    $oldSlot->save();
                    Log::debug('Old Slot set to available:', ['slot_id' => $oldSlot->id]);
                } else {
                    Log::debug('Old Slot is already available:', ['slot_id' => $oldSlot->id]);
                }
            } else {
                Log::error('Old Parking Lot not found:', ['slot_id' => $parking->slot_id]);
            }

            // Occupy the new slot
            $newSlot = ParkingLot::find($validated['slot_id']);
            if ($newSlot) {
                if ($newSlot->availability !== 'occupied') {
                    $newSlot->availability = 'occupied';
                    $newSlot->save();
                    Log::debug('New Slot set to occupied:', ['slot_id' => $newSlot->id]);
                } else {
                    Log::error('New Slot is already occupied:', ['slot_id' => $validated['slot_id']]);
                }

                // Update the slot details in the validated data
                $validated['slot'] = $newSlot->slot_name;
            } else {
                Log::error('New Parking Lot not found:', ['slot_id' => $validated['slot_id']]);
            }
        }

        // Handle paid status logic
        if (isset($validated['paid_status']) && $validated['paid_status'] === 'paid') {

            // Handle check_out date
            if (!isset($validated['check_out'])) {
                $validated['check_out'] = now();
            }
            // Set the slot availability to 'available' when parking is paid
            $slot = ParkingLot::find($validated['slot_id']);
            if ($slot) {
                $slot->availability = 'available';
                $slot->save();
                Log::debug('Slot availability set to available after payment:', ['slot_id' => $slot->id]);
            } else {
                Log::error('Slot not found to change availability:', ['slot_id' => $validated['slot_id']]);
            }

            if (isset($validated['rate_id'])) {
                $rateType = $rate->type ?? null;
                Log::debug('Rate Type:', ['rate_type' => $rateType]);

                if (isset($validated['check_out'])) {
                    $checkIn = \Carbon\Carbon::parse($validated['check_in']);
                    $checkOut = \Carbon\Carbon::parse($validated['check_out']);

                    switch ($rateType) {
                        case 'hourly':
                            $totalTime = $checkIn->diffInHours($checkOut);
                            $totalAmount = $totalTime * $rate->rate;
                            $validated['total_time'] = $totalTime;
                            $validated['total_amount'] = $totalAmount;
                            break;

                        case 'daily':
                            $totalTime = $checkIn->diffInDays($checkOut);
                            $totalAmount = $totalTime * $rate->rate;
                            $validated['total_time'] = $totalTime;
                            $validated['total_amount'] = $totalAmount;
                            break;

                        case 'fixed':
                            $validated['total_time'] = 1;
                            $validated['total_amount'] = $rate->rate;
                            break;

                        default:
                            Log::error('Unknown Rate Type:', ['rate_type' => $rateType]);
                            break;
                    }

                    Log::debug('Calculated Time and Amount:', [
                        'total_time' => $validated['total_time'],
                        'total_amount' => $validated['total_amount'],
                    ]);
                } else {
                    Log::error('Check-out date is missing or invalid.');
                }
            } else {
                Log::error('Rate information is missing or invalid.');
            }
        }

        Log::debug('Final Validated Data:', ['validated' => $validated]);

        try {
            // Update the parking record with the validated data
            $parking->update($validated);

            // Return success message
            return redirect()->route('parkings.index')->with('success', 'Parking record updated successfully.');
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error updating parking record:', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            // Return error message
            return redirect()->route('parkings.index')->with('error', 'Failed to update parking record.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
