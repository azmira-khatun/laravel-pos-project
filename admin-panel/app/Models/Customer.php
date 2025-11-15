<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * এই ফিল্ডগুলি CustomerController-এর store/update মেথড দ্বারা পূরণ করা হয়।
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'user_id', // কাস্টমারটি কোন ইউজার তৈরি করেছেন তার জন্য
    ];

    /**
     * Get the user that created the customer.
     * একটি কাস্টমার একটি ইউজারের সাথে যুক্ত (Many-to-One).
     */
    public function user(): BelongsTo
    {
        // ধরে নেওয়া হচ্ছে আপনার User মডেলটি App\Models\User পাথে রয়েছে
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sales associated with the customer.
     * একজন কাস্টমারের একাধিক সেলস ট্রানজেকশন থাকতে পারে।
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the sales invoices associated with the customer.
     * যদিও sales_invoices টেবিল customer_id ব্যবহার করে, এটিকে sales() এর মাধ্যমেও অ্যাক্সেস করা যেতে পারে।
     * তবে সরাসরি সম্পর্ক তৈরি করে দিলাম।
     */
    public function salesInvoices(): HasMany
    {
        return $this->hasMany(SalesInvoice::class);
    }

    /**
     * Get the revenue records associated with the customer.
     * একজন কাস্টমারের থেকে একাধিক রেভিনিউ রেকর্ড থাকতে পারে।
     */
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }

    /**
     * Get the sale returns records associated with the customer.
     * একজন কাস্টমার একাধিক পণ্য রিটার্ন করতে পারে।
     */
    public function saleReturns(): HasMany
    {
        return $this->hasMany(SaleReturn::class);
    }
}
