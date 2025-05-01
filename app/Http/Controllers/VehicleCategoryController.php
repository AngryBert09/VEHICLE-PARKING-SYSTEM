<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class VehicleCategoryController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $categories = VehicleCategory::all(); // Get all vehicle categories
        return view('admin.Vehicle.index', compact('categories'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.Vehicle.create');
    }

    // Store a newly created resource in storage.
    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'group_name' => 'required|string|max:255', // Update to 'group_name'
            'status' => 'required|in:active,inactive',
        ]);

        // Create a new category
        VehicleCategory::create([
            'group_name' => $validated['group_name'], // Reference 'group_name' instead of 'group'
            'status' => $validated['status'],
        ]);

        // Redirect with success message
        return redirect()->route('vehicle-categories.index')->with('success', 'Category created successfully!');
    }



    // Display the specified resource.
    public function show(VehicleCategory $vehicleCategory)
    {
        return view('vehicle-categories.show', compact('vehicleCategory'));
    }

    // Show the form for editing the specified resource.
    public function edit(VehicleCategory $vehicleCategory)
    {
        return view('admin.Vehicle.edit', compact('vehicleCategory'));
    }

    public function update(Request $request, VehicleCategory $vehicleCategory)
    {
        // Validate the input for group_name and status
        $validated = $request->validate([
            'group_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the vehicle category with the validated data
        $vehicleCategory->update([
            'status' => $validated['status'],
        ]);

        // Redirect with success message
        return redirect()->route('vehicle-categories.index')->with('success', 'Category updated successfully.');
    }


    // Remove the specified resource from storage.
    public function destroy(VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->delete();

        return redirect()->route('vehicle-categories.index')->with('success', 'Category deleted successfully.');
    }
}
