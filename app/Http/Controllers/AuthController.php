<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Book;
use App\Models\BookRequestView;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ViewInventory;
use App\Models\ViewBorrowedBook;
use App\Models\BorrowedBook;
use App\Models\BookRequest;

class AuthController extends Controller
{
    public function get_dashboard() {

    $records = ViewInventory::where('qty', '>=', 0)->get();

    // return response()->json($booksWithInventory);
    return Inertia::render('Dashboard', ['records' => $records]);
        
    }

    public function update_dashboard(Request $request, Inventory $id) {
        $record = $request->validate([
            'id' => 'required',
            'qty' => 'required',
        ]);

        Inventory::updateOrCreate(
            ['id' => $record['id']],
            ['qty' => $record['qty']],
        );

        return redirect()->route('dashboard-inventory');
    }

    public function get_borrow_request() {
        $borrowRequests = BookRequestView::all();
        // dd($records);
        return Inertia::render('BorrowRequest', ['borrowRequests' => $borrowRequests]);
    }
    public function get_borrowed_books() {
        $id = Auth::user()->id;
        
        $studentSideBorrow = ViewBorrowedBook::where('user_id', '=', $id)
            ->where('status', '=', 'active')
            ->get();
        $librarianSideBorrow = ViewBorrowedBook::where('status', '=', 'active')->get();


        return Inertia::render('BorrowedBooks', ['studentSideBorrow' => $studentSideBorrow, 'librarianSideBorrow' => $librarianSideBorrow]);
    }

    public function approve_request(Request $request) {
        //dd($request);
        $record = $request->validate([
            'request_id' => 'required',
            'book_id' => 'required',
            'user_id' => 'required',
            'inventory_id' => 'required',
            'request_qty' => 'required',
        ]);
        //dd($record);
        $updateBR = DB::table('book_requests')
            ->where('id', $record['request_id'])
            ->update(['status' => 'approved']);

        //dd($updateBR);
        $updateBB = DB::table('borrowed_books')
            ->updateOrInsert(
                ['inventory_id' => $record['inventory_id'], 'user_id' => $record['user_id'], 'qty' => $record['request_qty'], 'start_date' => Carbon::now()],
                ['status' => 'active']
            );
        
        // dd($updateBB);
        $currentQty = DB::table('inventories')
                        ->where('book_id', $record['book_id'])
                        ->value('qty');

        // Calculate the new quantity
        $newQty = $currentQty - $record['request_qty'];

        // Update or insert the inventory record with the new quantity
        $updateIN = DB::table('inventories')
                    ->updateOrInsert(
                        ['book_id' => $record['book_id']],
                        ['qty' => $newQty]
                    );


        // dd($updateIN);
        return redirect()->route('get-borrow-request');
        
    }

    public function decline_request(Request $request) {
        // dd($request);
        $record = $request->validate([
            'id' => 'required',
        ]);
        
        BookRequest::where('id', '=', $record['id'])
            ->update(['status' => 'declined']);
        
            return redirect()->route('get-borrow-request');
    }

    public function return(Request $request) {
        $data = $request->validate([
            'i_id' => 'required|integer',
            'b_id' => 'required|integer',
            'qty' => 'required|integer',
        ]);

        $qty = Inventory::where('id', '=', $data['i_id'])
            ->pluck('qty')
            ->first();

        Inventory::where('id', '=', $data['i_id'])
            ->update(['qty' => ($qty + $data['qty'])]);

        BorrowedBook::where('id', '=', $data['b_id'])
            ->update(['status' => 'returned']);

        return redirect()->route('get-borrowed-books', ['message' => 'Return Successful']);
    }  

    public function request_book() {
        $records = ViewInventory::where('qty', '>', 0)->get();

        return Inertia::render('RequestBook', ['records' => $records]);
    }

    public function request_book_post(Request $request) {
        $id = Auth::user()->id;

        $record = $request->validate([
            'id' => 'required|integer',
            'requestQty' => 'required|integer',
        ]);

        BookRequest::updateOrCreate(
            ['inventory_id' => $record['id'], 'user_id' => $id],
            ['qty' => $record['requestQty'], 'status' => 'pending', 'requested_at' => Carbon::now()],
        );
        return redirect()->route('request-book', ['message' => 'Request successful']);
    }

    public  function requested_book() {
        $id = Auth::user()->id;
        $requestBooks = BookRequestView::where('user_id', '=', $id)
            ->get();
        
            return Inertia::render('UserRequestedBook', ['requestBooks' => $requestBooks]);
    }

    public function cancel_request(Request $request) {
        $r = $request->validate([
            'id' => 'integer|required',
        ]);
        BookRequest::where('id', '=', $r['id'])
            ->update(['status' => 'cancelled']);

        return redirect()->route('requested-book', ['message' => 'Cancel request']);
    }
}
