<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopBill extends Model
{
    protected $table = 'shop_bills';

    use HasFactory;
    protected $fillable = [
        'user_id',
        'customer_name', // Add customer name
        'total_price',
        'paid_amount',
        'remaining_balance',
        'payment_method',
        'products',
        'status',
        'unique_id',
        'customer_shop_id' // Add status
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Bill.php
        public function products()
        {
            return $this->belongsToMany(Product::class, 'bill_product', 'bill_id', 'product_id')
                        ->withPivot('quantity'); // Assuming you have a pivot table 'bill_product'
        }

}
