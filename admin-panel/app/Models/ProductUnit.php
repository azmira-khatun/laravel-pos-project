<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    // টেবিলের নাম
    protected $table = 'product_units';

    // mass assignment এর জন্য fillable property
    protected $fillable = [
        'unit_name',
        'description',
    ];

    // timestamps true থাকলে created_at এবং updated_at auto manage হবে
    public $timestamps = true;
}
