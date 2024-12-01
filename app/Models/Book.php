<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = [
        'name',
        'description',
    ];

    public function borrowedBooks() {
        return $this->hasMany(BorrowedBook::class);
    }

    public function inventory() {
        return $this->hasOne(Inventory::class);
    }
}
