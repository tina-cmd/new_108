<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "logs";
    protected $fillable = [
        'table_name',
        'action',
        'record_id',
        'affected_columns',
        'performed_by',
        'log_time',
    ];
}
