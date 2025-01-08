<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class widgetsdetail extends Model
{
    use HasFactory;
    protected $table = 'widgetsdetail';

    protected $fillable = [
        'page_id', 'title', 'has_description', 'description', 'has_image', 'image', 'extra_fields'
    ];

    protected $casts = [
        'extra_fields' => 'array', 
    ];

    public function page()
    {
        return $this->belongsTo(widgets::class);
    }
}
