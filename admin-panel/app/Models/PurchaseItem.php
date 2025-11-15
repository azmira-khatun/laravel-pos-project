<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = 'purchase_items';

    // No updated_at column, so timestamps disabled
    public $timestamps = false;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'unit_price',
        'line_discount',
        'line_total',
    ];

    protected $casts = [
        'quantity'      => 'integer',
        'unit_price'    => 'decimal:2',
        'line_discount' => 'decimal:2',
        'line_total'    => 'decimal:2',
        'created_at'    => 'datetime',
    ];

    /**
     * Relationships
     */

    // A purchase item belongs to a purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    // A purchase item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function paymentMethod()
{
    return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
}
}
