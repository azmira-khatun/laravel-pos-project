<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
protected $fillable = [
'customer_id',
'payment_method_id',
'subtotal_amount',
'discount_amount',
'tax_amount',
'shipping_cost',
'total_cost',
'paid_amount',
'due_amount',
'payment_status',
'sell_date',
];


public function items()
{
return $this->hasMany(SalesItem::class, 'sale_id');
}


public function customer()
{
return $this->belongsTo(Customer::class);
}


public function paymentMethod()
{
return $this->belongsTo(PaymentMethod::class);
}
}
