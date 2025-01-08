<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'total_price',
        'paid_amount',
        'remaining_balance',
        'unique_id',
        'status'
    ];

    // Relationship with Bill
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
