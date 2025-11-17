<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitRecord extends Model
{
    protected $fillable = [
        'sale_item_id',
        'product_id',
        'cost_price',
        'selling_price',
        'profit_amount',
        'record_date',
    ];

    public function saleItem()
    {
        return $this->belongsTo(SalesItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
