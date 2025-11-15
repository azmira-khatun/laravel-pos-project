<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'type',
        'amount',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Relationship: Discount belongs to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
