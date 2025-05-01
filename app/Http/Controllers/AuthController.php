<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function showSignupForm()
    {
        return view('auth.signup'); // Adjust the view path if needed
    }

    public function showSigninForm()
    {
        return view('auth.signin'); // Adjust the view path if needed
    }

    public function signup(Request $request)
    {
        try {
            // Debug: Start signup process
            Log::debug('Starting signup process', ['input' => $request->all()]);

            // Validate Input with custom error messages
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
                'total_earnings' => 'nullable'
            ]);

            // Debug: Validation passed
            Log::debug('Validation passed for signup', [
                'validated_data' => $validated,
            ]);

            // Create User and assign default 'customer' role
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'roles' => 'customer', // Assign the 'customer' role by default
            ]);

            // Debug: User created successfully
            Log::debug('User created successfully', [
                'user_id' => $user->id,
                'user_role' => $user->roles,
            ]);

            // Redirect to the signin page with success message
            Log::info('Signup process completed successfully', [
                'user_id' => $user->id,
            ]);
            return redirect()->route('signin.form')->with('success', 'Account created successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Debug: Database query exception
            Log::error('Database query exception during signup', [
                'error_message' => $e->getMessage(),
                'sql_state_code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Handle database-related errors
            if ($e->getCode() === '23000') { // SQL state for duplicate entry
                Log::warning('Duplicate email entry detected', ['email' => $request->email]);
                return redirect()->back()->withErrors([
                    'email' => 'The email address is already in use. Please choose a different one.',
                ]);
            }

            return redirect()->back()->withErrors([
                'error' => 'An error occurred while creating the account. Please try again later.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Debug: Validation exception
            Log::error('Validation exception during signup', [
                'validation_errors' => $e->validator->errors(),
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $errors = $e->validator->errors();

            // Debug: Check for specific validation error
            if ($errors->has('password')) {
                Log::warning('Password validation failed', [
                    'password_errors' => $errors->get('password'),
                ]);
                return redirect()->back()->withErrors([
                    'password' => 'The passwords do not match or your password is a minimum of 8 characters.',
                ]);
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            // Debug: General exception
            Log::critical('Unexpected exception during signup', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors([
                'error' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }




    public function signin(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $throttleKey = Str::lower($email) . '|' . $request->ip();

        // Check if the user has too many login attempts
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.',
                'lockout_duration' => $seconds, // Inform the user of lockout duration
            ])->withInput();
        }

        // Attempt to find the user by email
        $user = User::where('email', $email)->first();

        // Authenticate the user
        if ($user && Auth::attempt($credentials)) {
            // Clear any failed login attempts on successful login
            RateLimiter::clear($throttleKey);

            // Regenerate session for security
            $request->session()->regenerate();

            // Redirect based on user role
            switch ($user->roles) {
                case 'admin':
                    return redirect()->route('dashboard')->with('success', 'Welcome back, Admin!');
                case 'attendant':
                    return redirect()->route('dashboard')->with('success', 'Welcome back, Attendant!');
                default:
                    return redirect()->route('DashboardUser')->with('success', 'Welcome back, Customer!');
            }
        }

        // Log the failed login attempt
        RateLimiter::hit($throttleKey, 60); // 60-second lockout for failed attempts

        // Handle errors for non-existent user
        if (!$user) {
            return back()->withErrors([
                'email' => 'The email address is not registered.',
            ])->onlyInput('email');
        }

        // Handle incorrect password
        return back()->withErrors([
            'password' => 'The password you entered is incorrect.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        // Log the user out of the application
        Auth::logout();

        // Invalidate the session to prevent session fixation attacks
        $request->session()->invalidate();

        // Regenerate the CSRF token to avoid security issues
        $request->session()->regenerateToken();

        // Redirect the user to the login page with a success message
        return redirect()->route('signin.form')->with('success', 'You have been logged out successfully.');
    }
}
