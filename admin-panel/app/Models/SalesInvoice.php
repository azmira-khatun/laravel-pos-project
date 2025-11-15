<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    protected $table = 'sales_invoices';

    protected $fillable = [
        'invoice_number',
        'sale_id',
        'customer_id',
        'invoice_date',
        'total_amount',
        'due_amount',
        'payment_status',
    ];

    // যদি relationship দরকার হয়:
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
