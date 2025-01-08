<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules_images extends Model
{
    protected $table = 'modules_images';

    use HasFactory;

    protected $fillable = ['module_id', 'image'];

    public function module()
    {
        return $this->belongsTo(Modules::class, 'module_id');
    }
}
