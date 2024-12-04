<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    protected $fillable = [
        'book_id', 
        'qty'
    ];

    // Relationship with Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
}
