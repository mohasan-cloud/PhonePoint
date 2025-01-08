<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    protected $table = 'admin_settings';


    protected $fillable = ['site_name', 'favicon', 'logo','footer_logo','address','email_1','email_2','email_3','phone_1','phone_2','phone_3','facebook','twitter','Instagram','linkedin','youtube','tiktok'];
}
