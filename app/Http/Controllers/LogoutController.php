<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        // Logout the user
        Auth::logout();

        // Invalidate the session (optional but recommended)
        $request->session()->invalidate();

        // Regenerate CSRF token (optional)
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('get-home', ['message' => 'Logout Successfully.']);
    }
}
