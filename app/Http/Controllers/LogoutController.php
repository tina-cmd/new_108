<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        // Logout the user

        DB::purge(session('db_connection'));
        config(['database.default' => 'pgsql']);
        DB::reconnect('pgsql');

        Auth::logout();

        $request->session()->forget('db_connection');
        // Invalidate the session (optional but recommended)
        $request->session()->invalidate();
        // Regenerate CSRF token (optional)
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('get-home', ['message' => 'Logout Successfully.']);
    }
}
