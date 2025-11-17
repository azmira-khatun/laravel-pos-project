<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'vendor_id',
        'user_id',
        'subtotal_amount',
        'discount_amount',
        'tax_amount',
        'shipping_cost',
        'total_cost',
        'paid_amount',
        'due_amount',
        'payment_method_id',
        'payment_status',
        'purchase_date',
        'receive_date',
    ];

    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'total_cost'      => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'due_amount'      => 'decimal:2',
        'purchase_date'   => 'datetime',
        'receive_date'    => 'date',
    ];

    /**
     * Relationships
     */

    // Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // User who created the purchase
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Payment
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // ⭐ MOST IMPORTANT: A purchase has many purchase items
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }
     public function product() {
        return $this->belongsTo(Product::class);
    }
}
