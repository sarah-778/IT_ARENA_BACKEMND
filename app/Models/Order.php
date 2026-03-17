<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'email', 
        'district', 'address', 'items', 'subtotal', 
        'delivery_fee', 'total', 'status'
    ];
    
    protected $casts = [
        'items' => 'array'
    ];
}