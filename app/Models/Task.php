<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'event_name',
        'location',
        'total_price',
        'paid_amount',
        'shot_date',
        'print_date',
        'user_id',
        'type',
        'package',
        'size',
        'quantity',
        'status',
        'remark'
    ];
}
