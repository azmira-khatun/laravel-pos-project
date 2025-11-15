<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageProduct extends Model
{
    use HasFactory;

    protected $table = 'damage_products';

    protected $fillable = [
        'product_id',
        'quantity',
        'unit_price',
        'description',
        'user_id',
        'noted_on',
    ];

    // সম্পর্ক (optional)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
