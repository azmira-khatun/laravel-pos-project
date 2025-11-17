<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    protected $table = 'sales_items';
    public $timestamps = true;

    protected $fillable = [
        'sale_id',
        'product_id',
        'productunit_id',
        'quantity',
        'unit_price',
        'discount_id', // added
        'discount_amount',
        'tax_amount',
        'batch_no',
        'expiry_date',
        'description',
        'line_total',
        'status',
    ];

    protected $casts = [
        'quantity'        => 'integer',
        'unit_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'line_total'      => 'decimal:2',
        'expiry_date'     => 'date',
    ];

    // -------------------------
    // Relationships
    // -------------------------

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Item belongs to a unit (using productunit_id as per migration)
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }

    // Item can belong to a discount (using discount_id as per migration)
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
