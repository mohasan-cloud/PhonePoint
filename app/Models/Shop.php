<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_name',
        'owner_name',
        'shop_location',
        'near_shop',
        'reference_name',
        'reference_shop',
        'cnic_image',
        'balance',
        'user_id',
        'shop_unique_id'
    ];

}
