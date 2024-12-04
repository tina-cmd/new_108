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
    
        // Switch to the appropriate database connection
        $dbConnectionResult = $this->setDatabaseConnection($creds['role']);
    
        if (isset($dbConnectionResult['error'])) {
            return Inertia::render('LoginPage', ['error' => $dbConnectionResult['error']]);
        }
        
        
        
        // Check if credentials match a user
        if (Auth::attempt(['username' => $creds['username'], 'password' => $creds['password']], $remember)) {
            $user = Auth::user();
    
            // Verify role
            if ($user->role !== $creds['role']) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
    
                return Inertia::render('LoginPage', ['error' => 'Invalid role']);
            }
            
            // $currentUser = DB::select('SELECT CURRENT_USER')[0]->current_user;
            // dd($currentUser);

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
        $connectionName = $connections[$role];

        // Purge previous connection
        DB::purge($connectionName);

        // Set the new connection
        DB::setDefaultConnection($connectionName);

        try {
            DB::connection($connectionName)->getPdo();

            if($connections[$role] === 'librarian') {
                DB::connection($connectionName)->statement("SET ROLE " . 'postgres');
                DB::connection($connectionName)->statement("SET SESSION AUTHORIZATION postgres"); // Set the session authorization (to change the current user)
            } elseif($connections[$role] === 'member') {
                DB::connection($connectionName)->statement("SET ROLE " . 'student');
                DB::connection($connectionName)->statement("SET SESSION AUTHORIZATION student"); // Set the session authorization (to change the current user)
            } else {
                DB::connection($connectionName)->statement("SET ROLE " . $connections[$role]);
                DB::connection($connectionName)->statement("SET SESSION AUTHORIZATION assistant"); // Set the session authorization (to change the current user)
                // $currentUser = DB::select('SELECT CURRENT_USER')[0]->current_user;
                // dd($currentUser);
            }
        } catch (\Exception $e) {
            return ['error' => 'Failed to connect to the database for role: ' . $role];
        }
    } else {
        return ['error' => 'Invalid role specified.'];
    }

    return ['success' => true];
}

}
