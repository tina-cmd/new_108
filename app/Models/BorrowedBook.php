<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    protected $table = 'borrowed_books';
    protected $fillable = [
        'inventory_id', 
        'user_id', 
        'qty', 
        'start_date', 
        'end_date', 
        'status'
    ];

    // Relationship with Book
    public function bookRequest() {
        return $this->belongsTo(BookRequest::class);
    }
}
