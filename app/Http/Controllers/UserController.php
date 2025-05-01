<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        // Pass the sorted parkings to the view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,customer,attendant', // Include 'attendant' in the roles
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Determine the default password based on the role
        $password = match ($request->role) {
            'admin' => 'admin123',
            'customer' => 'customer123',
            'attendant' => 'attendant123', // Default password for attendants
            default => 'password123', // Fallback in case of an unexpected role
        };

        // Create the user and assign the role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password), // Hash the password
            'roles' => $request->role, // Store the role directly in the user record
        ]);

        // Optionally, log the default password creation (e.g., email notification)

        // Redirect to the users listing page with a success message
        return redirect()->route('users.index')->with('success', "User '{$user->name}' created successfully with the role '{$user->roles}'.");
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
    public function edit(User $user)
    {

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'role' => 'nullable|in:admin,customer,attendant', // Ensure valid role is selected
        ]);

        // Find the user to update
        $user = User::findOrFail($id);

        // Check if the user is an admin and if it's the last admin
        if ($user->roles === 'admin' && $validated['role'] !== 'admin') {
            $adminCount = User::where('roles', 'admin')->count();

            if ($adminCount <= 1) {
                // If this is the last admin, do not allow role change
                return redirect()->route('users.index')->with('error', 'You cannot remove the last admin.');
            }
        }

        // Update the user details
        $user->name = $validated['name'];
        $user->roles = $validated['role'];
        $user->save();

        // Redirect to the users index with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if the user is an admin
        if ($user->roles === 'admin') {
            // Count the remaining admins
            $adminCount = User::where('roles', 'admin')->count();

            // If this is the last admin, deny deletion
            if ($adminCount <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'You cannot delete the last admin.');
            }
        }

        // Proceed with deletion if not the last admin
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Parking record deleted successfully.');
    }
}
