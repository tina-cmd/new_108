<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewBorrowedBook extends Model
{
    protected $table = 'view_borrowed_books';
    protected $fillable = [
        'id',
        'inventory_id',
        'book_id',
        'user_id',
        'book_name',
        'student_name',
        'qty',
    ];
}
