<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'productunit_id',
        'customer_id',
        'product_id',
        'payment_method_id',
        'payment_status',
        'paid_amount',
        'sell_date',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
