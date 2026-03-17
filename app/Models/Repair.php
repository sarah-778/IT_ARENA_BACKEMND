<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 
        'name', 
        'phone', 
        'email', 
        'device', 
        'issue', 
        'date', 
        'image', 
        'status', 
        'tracking_code' // Added
    ];
}