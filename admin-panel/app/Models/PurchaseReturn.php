<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $table = 'purchase_returns';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_name',
        'total_quantity',
        'subtotal_amount',
        'tax_amount',
        'shipping_cost',
        'return_quantity',
        'refund_amount',
        'net_refund',
        'payment_method',
        'status',
        'note',
    ];

    /**
     * Beziehungen / relations
     */

    // PurchaseReturn belongs to a Purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // PurchaseReturn belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
