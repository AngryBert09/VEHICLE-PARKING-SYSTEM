<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\VehicleCategory;

class RatesController extends Controller
{
    // Display a listing of rates
    public function index()
    {
        $rates = Rate::all(); // Get all rates from the database
        return view('admin.rates.index', compact('rates')); // Pass data to the 'rates.index' view
    }

    // Show the form for creating a new rate
    public function create()
    {
        // Get all vehicle categories from the database
        $vehicleCategories = VehicleCategory::all();
        return view('admin.rates.create', compact('vehicleCategories'));
    }

    // Store a new rate in the database
    public function store(Request $request)
    {
        // Debugging: Check the raw request data
        Log::debug('Raw Request Data:', $request->all());

        // Validate the request input
        $validated = $request->validate([
            'rate_name' => 'required|string|max:255',
            'category' => 'required|exists:vehicle_categories,id', // Validate that the category exists in the vehicle_categories table
            'type' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Debugging: Log validated data
        Log::debug('Validated Data:', $validated);

        // Create a new rate record in the database
        try {
            Rate::create([
                'rate_name' => $validated['rate_name'], // Store the rate name
                'category_id' => $validated['category'], // Store the category_id (which is the vehicle category's id)
                'type' => $validated['type'], // Store the rate type
                'rate' => $validated['rate'], // Store the rate value
                'status' => $validated['status'], // Store the status
            ]);

            // Redirect back with success message
            return redirect()->route('rates.index')->with('success', 'Rate created successfully!');
        } catch (\Exception $e) {
            // Log error if creation fails
            Log::error('Rate creation failed:', ['error' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);

            // Optionally, return the error message back to the user
            return redirect()->route('rates.index')->with('error', 'Failed to create rate.');
        }
    }




    // Show the form for editing a specified rate
    public function edit(Rate $rate)
    {
        $vehicleCategories = VehicleCategory::all();
        return view('admin.rates.edit', compact('vehicleCategories', 'rate'));
    }

    // Update the specified rate in storage
    public function update(Request $request, Rate $rate)
{
    // Debugging: Log the raw request data
    Log::debug('Raw Request Data:', $request->all());

    // Validate the request input
    $validated = $request->validate([
        'rate_name' => 'nullable|string|max:100', // nullable, meaning it's optional
        'category' => 'nullable|exists:vehicle_categories,id', // Ensure category exists in the vehicle_categories table
        'type' => 'nullable|string|max:100',
        'rate' => 'nullable|numeric|min:0',
        'status' => 'nullable',
    ]);

    // Debugging: Log the validated data
    Log::debug('Validated Data:', $validated);

    // Update the rate record in the database
    try {
        // Log the current state of the rate record before update
        Log::debug('Current Rate Data:', [
            'rate_name' => $rate->rate_name,
            'category_id' => $rate->category_id,
            'type' => $rate->type,
            'rate' => $rate->rate,
            'status' => $rate->status,
        ]);

        // Update the rate record only for the fields that are provided
        $rate->update(array_filter([
            'category_id' => $validated['category'] ?? $rate->category_id, // If category is provided, use it; otherwise, keep the existing value
            'type' => $validated['type'] ?? $rate->type,                   // Same for type
            'rate' => $validated['rate'] ?? $rate->rate,                   // Same for rate
            'status' => $validated['status'] ?? $rate->status,             // Same for status
        ]));

        // Log successful update
        Log::debug('Rate Updated Successfully:', [
            'rate_name' => $validated['rate_name'] ?? $rate->rate_name,
            'category_id' => $validated['category'] ?? $rate->category_id,
            'type' => $validated['type'] ?? $rate->type,
            'rate' => $validated['rate'] ?? $rate->rate,
            'status' => $validated['status'] ?? $rate->status,
        ]);

        // Redirect back with a success message
        return redirect()->route('rates.index')->with('success', 'Rate updated successfully!');
    } catch (\Exception $e) {
        // Log error if update fails
        Log::error('Rate update failed:', [
            'error' => $e->getMessage(),
            'stack' => $e->getTraceAsString(),
            'rate_data' => $validated // Log the validated data that was intended for update
        ]);

        // Optionally, return an error message to the user
        return redirect()->route('rates.index')->with('error', 'Failed to update rate.');
    }
}



    // Remove the specified rate from storage
    public function destroy(Rate $rate)
    {
        try {
            // Delete the rate record from the database
            $rate->delete();

            // Redirect back with success message
            return redirect()->route('rates.index')->with('success', 'Rate deleted successfully!');
        } catch (\Exception $e) {
            // Log error if deletion fails
            Log::error('Rate deletion failed:', ['error' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);

            return redirect()->route('rates.index')->with('error', 'Failed to delete rate.');
        }
    }

    // Add the show method in the RatesController
    public function show(Rate $rate)
    {
        return view('admin.rates.show', compact('rate')); // Pass the rate data to a show view
    }
}
