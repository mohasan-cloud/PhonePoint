<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoManagement extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'seo_management'; // Optional, if table name is not plural of the model name.

    // The attributes that are mass assignable
    protected $fillable = [
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
