<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function get_dashboard() {

    $records = Book::join('inventory', 'books.id', '=', 'inventory.book_id')
        ->select('inventory.id','books.name', 'books.description', 'inventory.qty')
        ->get();

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
        return Inertia::render('BorrowRequest');
    }
    public function get_borrowed_books() {
        return Inertia::render('BorrowedBooks');
    }
}
