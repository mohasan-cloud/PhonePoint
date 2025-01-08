<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'title', 'content'];

    public function book() {
        return $this->belongsTo(Book::class);
    }
    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}
