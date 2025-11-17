<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'payment_method_id',
        'payment_status',
        'paid_amount',
        'subtotal_amount',
        'discount_amount',
        'tax_amount',
        'shipping_cost',
        'total_cost',
        'due_amount',
        'sell_date',
    ];

    // --------------------------
    // Relationships
    // --------------------------

    // A sale belongs to one customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // A sale belongs to one payment method
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // A sale has many items
    public function items()
    {
        return $this->hasMany(SalesItem::class);
    }

    // Access products through items (optional)
    public function products()
    {
        return $this->hasManyThrough(Product::class, SalesItem::class);
    }
}
