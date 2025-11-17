<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'purchase_id',
        'sale_id',
        'sale_return_id',
        'purchase_return_id',
        'damage_id',
        'movement_type',
        'quantity',
        'user_id',
        'movement_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }



    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    public function damage()
    {
        return $this->belongsTo(DamageProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
