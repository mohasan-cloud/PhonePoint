<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'routes';

    // Specify the fillable fields
    protected $fillable = ['name', 'url', 'breadcrumb_title', 'breadcrumb_image','module_id','type','sub_menu_url','order','has_sub_menus'];

    // Define the submenus relationship
    public function subMenus()
    {
        return $this->hasMany(SubMenu::class);
    }

    // Override boot method to handle cascading deletes
    protected static function boot()
    {
        parent::boot();

        // Delete related submenus when a route is deleted
        static::deleting(function ($route) {
            $route->subMenus()->delete();
        });
    }
}
