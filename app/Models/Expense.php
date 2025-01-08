<?php
// app/Models/Expense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name', 'cost', 'expense_type', 'description','user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
