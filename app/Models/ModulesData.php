<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulesData extends Model
{
    protected $table = 'modules_data';

    protected $fillable = ['title', 'description', 'category', 'sub_category', 'module_id', 'meta_title', 'meta_keywords', 'meta_description', 'image', 'images','user_id','extra_field_1','extra_field_2','extra_field_3','extra_field_4','extra_field_5','extra_field_6','extra_field_7','extra_field_8','extra_field_9','extra_field_10','extra_field_10','extra_field_12','extra_field_13','extra_field_14','extra_field_15','extra_field_16','extra_field_17','extra_field_18','extra_field_19','extra_field_20'];

    public function results()
    {
        return $this->hasMany('App\Models\ModulesData','category');
    }

    public function count()
    {
        return $this->results()->count();
    }

}
