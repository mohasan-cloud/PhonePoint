<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'total_price',
        'paid_amount',
        'remaining_balance',
        'payment_method',
        'products',
        'status',
        'unique_id',
        'discount_details',
        'discount',
    ];

    protected $casts = [
        'discount_details' => 'array',
        'products' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bill_product', 'bill_id', 'product_id')
            ->withPivot('quantity'); // Assuming you have a pivot table 'bill_product'
    }
}
