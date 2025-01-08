<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'buy_price',
        'sell_price',
        'quantity',
        'barcode',
        'discount_percentage',
        'discount_price',
        'hole_sale_price',
        'categories_id',
        'product_profit',
        'hole_sale_percentage'
    ];
    // Product.php
public function bills()
{
    return $this->belongsToMany(Bill::class, 'bill_product', 'product_id', 'bill_id')
                ->withPivot('quantity');
}
// Product.php

public function category()
{
    return $this->belongsTo(Category::class, 'categories_id');
}

}
