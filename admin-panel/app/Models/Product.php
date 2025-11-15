<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // যদি আপনার table নাম convention অনুসারে না হয় তাহলে uncomment করুন:
    // protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'sub_category_id',
        'productunit_id',
        'barcode',
        'description',
    ];

    // যদি primary key নাম convention অনুসারে না হয় তাহলে uncomment করুন:
    // protected $primaryKey = 'id';

    // সম্পর্কগুলো (Relationships) নির্ধারণ করা যায়:
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }

     public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
