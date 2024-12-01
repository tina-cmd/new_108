<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Inventory;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookController extends Controller
{
    public function get_books(Request $request) {
        $books = Book::all();
        return Inertia::render('Book', [ 'books' => $books ]);
    }

    public function delete_books(Book $id) {
        $id->delete();
        return redirect()->back();
    }

    public function add_books(Request $request) {
        $book = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'qty' => 'required|integer',
        ]);

        $bookExists = Book::where('name', '=', $book['name'])->first();

        
        if($bookExists) {
            // $books = Book::all();
            // return Inertia::render('Book', ['books' => $books, 'message' => 'Book already exists']);
            return redirect()->route('get-books')->with('error', 'Book already exists!');
        }
        // // dd($getBook);
        Book::create([
            'name' => $book['name'],
            'description' => $book['description'],
            'created_at' => Carbon::now(),
        ]);

        Inventory::create([
            'book_id' => Book::latest('id')->first()->id,
            'qty' => $book['qty'],
        ]);
        return redirect()->route('get-books')->with('success', 'Book added successfully!');
    }

    public function edit_books(Request $request, Book $id) {
        $record = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        DB::table('books')
              ->where('id', $id->id)
              ->update(['name' => $record['name'], 'description' => $record['description'], 'updated_at' => Carbon::now()]);
        
              return redirect()->back();
    }
}
