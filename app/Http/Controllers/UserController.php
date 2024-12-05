<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Log;

class UserController extends Controller
{
    public function get_users() {
        $users = User::all();
        return Inertia::render('ManageUser', ['users' => $users]);
    }

    public function delete_user(User $id) {
        $id->delete();
        return redirect()->back();
    }

    public function update_user(Request $request, User $id) {

        // dd($request->role);
        $role = $request->validate([
            'role' => 'required',
        ]);

        $id->update($role);
        return redirect()->back();
    }

    public function get_logs() {
        $logs = Log::all();

        // Format the log time to a more readable format
        // $logs->each(function ($log) {
        //     $log->log_time = $log->log_time->format('Y-m-d H:i:s');  // You can customize the format as needed
        // });

        return Inertia::render('Logs', ['logs' => $logs]);
    }
}
