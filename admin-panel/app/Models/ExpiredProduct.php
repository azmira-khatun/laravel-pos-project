<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredProduct extends Model
{
    use HasFactory;

    // যদি টেবিল নাম স্বয়ংক্রিয় নয় হয় তাহলে
    // protected $table = 'expired_products';

    protected $fillable = [
        'product_id',
        'expiry_date',
        'user_id',
        'noted_on',
    ];

    // যদি timestamps না থাকে তাহলে:
    // public $timestamps = false;

    // রিলেশন: product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // রিলেশন: user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
