<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'method_name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

      public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'payment_method_id');
    }
    // Relationships based on the schema design

    // public function purchases(): HasMany
    // {
    //     return $this->hasMany(Purchase::class);
    // }

    // public function sales(): HasMany
    // {
    //     return $this->hasMany(Sale::class);
    // }

    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Payment::class);
    // }
}
