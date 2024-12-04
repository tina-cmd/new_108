<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $table = 'book_requests';
    protected $fillable = [
        'inventory_id',
        'user_id',
        'qty',
        'status',
        'requested_at',
    ];

    public function inventory() {
        return $this->belongsTo(Inventory::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
