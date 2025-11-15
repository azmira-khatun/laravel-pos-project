<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'purchase_id',
        'invoice_date',
        'total_amount',
        'due_amount',
        'payment_status',
    ];

    // Relation: Each invoice belongs to one purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
