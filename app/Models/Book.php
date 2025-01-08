<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_id','user_id'];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }
}
