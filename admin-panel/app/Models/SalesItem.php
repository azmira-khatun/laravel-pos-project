<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    protected $table = 'sales_items';

    protected $fillable = [
        'sale_id',
        'product_id',
        'productunit_id',
        'quantity',
        'unit_price',
        'discount_id',
        'discount_amount',
        'tax_amount',
        'batch_no',
        'expiry_date',
        'description',
        'line_total',
        'total_cost',
        'status',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }
}
