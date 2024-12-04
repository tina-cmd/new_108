<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewInventory extends Model
{
    protected $table = 'view_inventory';
    protected $fillable = [
        'id',
        'name',
        'description',
        'book_id',
        'qty',
    ];
}
