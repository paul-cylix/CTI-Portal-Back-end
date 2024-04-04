<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    const TRUE = 1;
    const FALSE = 0;

    protected $fillable = [
        'user_id',
        'mode',
        'category_id',
        'notes',
        'date_entry',
        'time_entry',
        'latitude',
        'longitude',
        'images',
        'timestart',
        'push_status',
        'first_in'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
