<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechioMarekting  extends Model
{
    use HasFactory;
    protected $table = 'techiomarekting';

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_link',
        'option1',
        'option2',
        'option3',
        'option4',
        'level_image',
        'level_text',
        'level_button_name',
        'level_button_link'
    ];
}
