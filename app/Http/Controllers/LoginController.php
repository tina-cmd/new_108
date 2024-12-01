<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\User;

class LoginController extends Controller
{
    public function get_home()
    {
        if(Auth::check()) {
            if(Auth::user()->role === 'member') {
                return redirect()->route('get-borrowed-books');
            }
            return redirect()->route('dashboard-inventory');
        }
        return Inertia::render('Home');
    }

    public function get_register() {
        if(Auth::check()) {
            if(Auth::user()->role === 'member') {
                return redirect()->route('get-borrowed-books');
            }
            return redirect()->route('dashboard-inventory');
        }
        return Inertia::render('RegisterPage');
    }

    public function register(Request $request) {
        $creds = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'student' => 'required',
        ]);

        $exist = User::where('username', $request->username)->where('password', bcrypt($request->password))->first();
        if($exist) {
            return back()->withErrors(['username' => 'Username already exists.']);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'member',
        ]);


        Auth::login($user);

        return redirect()->route('get-borrowed-books');
    }

    public function get_login()
    {
        if(Auth::check()) {
            if(Auth::user()->role === 'member') {
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
        ]);
        $remember = $request->has('remember');

        // Check if credentials match a user
        if (Auth::attempt(['username' => $creds['username'], 'password' => $creds['password']], $remember)) {
            $user = Auth::user();

            // Verify role
            if ($user->role !== $creds['role']) {
                Auth::logout();

                return Inertia::render('LoginPage', ['error' => 'Invalid role']);
            }

            // Switch to the appropriate database connection
            $con = $this->setDatabaseConnection($creds['role']);
            
            if($user->role === 'librarian' || $user->role === 'assistant') {
                return redirect()->route('dashboard-inventory', ['connection' => $con]);
            }
            return redirect()->route('get-borrowed-books', ['connection' => $con]);
            
            // Redirect to the dashboard
            // return redirect()->route('dashboard');
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
            $connectionName = $connections[$role];

            // Set the default database connection
            DB::setDefaultConnection($connectionName);
            $defaultCon = DB::getDefaultConnection();

            // Test the connection
            try {
                DB::connection($connectionName)->getPdo();
                return $defaultCon;
            } catch (\Exception $e) {
                throw new \RuntimeException("Failed to connect to the $connectionName database: " . $e->getMessage());
            }
        } else {
            throw new \InvalidArgumentException("Invalid role for database connection");
        }
    }
}
