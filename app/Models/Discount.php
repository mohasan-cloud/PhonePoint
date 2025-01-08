<?php
// app/Models/Discount.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';

    use HasFactory;

    protected $fillable = ['name', 'percentage','status'];
}
