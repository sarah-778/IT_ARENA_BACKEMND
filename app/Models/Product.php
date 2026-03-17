<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category',
        'brand',        // Added for Dynamic Selection
        'price',
        'stock',
        'isOEM',
        'warranty',     // Added for Professional Specs
        'image',        // Added for Photo Uploads
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'isOEM' => 'boolean',
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
}