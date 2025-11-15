<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'productunit_id',
        'payment_method_id',
        'customer_id',
        'product_id',
        'payment_status',
        'paid_amount',
        'sell_date',
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'sell_date'   => 'datetime',
    ];

    // Relationships
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
