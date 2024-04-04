<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    const TRUE = 1;
    const FALSE = 0;

    const RJCT = 'Reject';
    const ACTV = 'Active';
    const APVL = 'For Approval';

    protected $fillable = [
        'user_id',
        'date_entry',
        'clock_in',
        'clock_out',
        'status',
        'push_status'
    ];
}
