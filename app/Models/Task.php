<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\StaffTask;

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
        'delivery_date',
        'user_id',
        'type',
        'package',
        'description',
        'quantity',
        'status',
        'remark',
        'service',
        'data_location',
        'selection_date',
        'tax'
    ];

    public function staffs(){
        return $this->belongsToMany(User::class, 'staff_tasks', 'task_id', 'staff_id');
    }

    public function scopeOrderByStatus($query)
    {
        return $query->orderBy('status','desc');
    }
}
