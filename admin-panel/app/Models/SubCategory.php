<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    // যদি টেবিল নাম Laravel স্বয়ং ধরতে না পারে তাহলে:
    // protected $table = 'sub_categories';

    // ভর (mass) অ্যাসাইনমেন্ট নিয়ন্ত্রণ করার জন্য:
    protected $fillable = [
        'name',
        'category_id',
    ];

    // রিলেশনশিপ: প্রতিটি সাব ক্যাটেগরির একটি ক্যাটেগরি আছে
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

     public function products()
    {
        return $this->hasMany(Product::class);
    }
}
