<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;
    protected $table = 'trafic';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'ip_address',
        'location',
        'source',
        'time_spent',
        'browser',
        'device',
        'visit_date',
        'views',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'time_spent' => 0, // Default duration is 0 seconds
        'views' => 0,      // Default views count
    ];
}
