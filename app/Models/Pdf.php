<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'file_path',
    ];

    // Define the relationship with the Chapter model
    public function chapter()
    {
        return $this->belongsTo(Chapter::class); // Assumes you have a Chapter model
    }
}
