<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function get_home()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'member') {
                return redirect()->route('get-borrowed-books');
            }
            return redirect()->route('dashboard-inventory');
        }
        return Inertia::render('Home');
    }

    
    public function get_register()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'member') {
                return redirect()->route('get-borrowed-books');
            }

            return redirect()->route('dashboard-inventory');
        }

        return Inertia::render('RegisterPage');
    }

    public function register(Request $request)
    {
        $creds = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'student' => 'required',
        ]);

        $exist = User::where('username', $request->username)->where('password', bcrypt($request->password))->first();
        if ($exist) {
            return back()->withErrors(['username' => 'Username already exists.']);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'member',
        ]);

        // dd($user['role']);
        $connect = $this->setDatabaseConnection($user['role']);
        Auth::login($user);

        return redirect()->route('get-borrowed-books');
    }

    public function get_login()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'member') {
                return redirect()->route('get-borrowed-books');
            }

            return redirect()->route('dashboard-inventory');
        }

        return Inertia::render('LoginPage');
    }

    public function login(Request $request)
    {
        $creds = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:librarian,assistant,member',
            'remember' => 'boolean',
        ]);

        $remember = $request->has('remember');
        $rememberMe = $request->remember;

        // Switch to the appropriate database connection
        $dbConnectionResult = $this->setDatabaseConnection($creds['role']);

        if (isset($dbConnectionResult['error'])) {
            return Inertia::render('LoginPage', ['error' => $dbConnectionResult['error']]);
        }
        $isFound = false;
        if($rememberMe) {
            if(Auth::attempt(['username' => $creds['username'], 'password' => $creds['password']], $remember)) {
                $isFound = true;
            }
        } else {
            if(Auth::attempt(['username' => $creds['username'], 'password' => $creds['password']])) {
                $isFound = true;
            }
        }

        // Check if credentials match a user
        if ($isFound) {
            $user = Auth::user();

            // Verify role
            if ($user->role !== $creds['role']) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $request->session()->forget('db_connection');

                return Inertia::render('LoginPage', ['error' => 'Invalid role']);
            }

            // Redirect based on role
            if ($user->role === 'librarian' || $user->role === 'assistant') {
                return redirect()->route('dashboard-inventory');
            }

            return redirect()->route('get-borrowed-books');
        }

        // Invalid credentials
        return Inertia::render('LoginPage', ['error' => 'Invalid credentials']);
    }

    private function setDatabaseConnection(string $role)
    {
        $connections = [
            'librarian' => 'librarian',
            'assistant' => 'assistant',
            'member' => 'member',
        ];

        if (isset($connections[$role])) {
            $connectionName = $connections[$role]; // Use the connection name from the mapping
            session(['db_connection' => $connectionName]);

            // dd(session('db_connection'));
            try {
                // Clear the current connection
                DB::purge($connectionName);

                // Update the default connection configuration
                config(['database.default' => $connectionName]);
                // dd(config('database.default'));

                // Reconnect using the updated configuration
                DB::reconnect($connectionName);

                // Test the connection
                $pdo = DB::connection($connectionName)->getPdo();

            } catch (\Exception $e) {
                return ['error' => 'Failed to connect to the database for role: '.$role];
            }
        } else {
            return ['error' => 'Invalid role specified.'];
        }

        return ['success' => true];
    }
}
