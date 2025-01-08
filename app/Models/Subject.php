<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id', 'user_id', 'image'];

    public function classModel() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }


    public function books() {
        return $this->hasMany(Book::class);
    }
    public function class()
{
    return $this->belongsTo(ClassModel::class);
}
}
