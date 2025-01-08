<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu  extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'sub_menus';

    // Specify the fillable fields
    protected $fillable = ['route_id', 'name', 'url'];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
