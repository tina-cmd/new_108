<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    protected $table = 'borrowed_books';
    protected $fillable = [
        'book_id', 
        'user_id', 
        'qty', 
        'start_date', 
        'end_date', 
        'status'
    ];

    // Relationship with Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
