<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    public $table = 'property_images';

    public $fillable = [
        'url',
        'property_id'
    ];

    protected $casts = [
        'url' => 'string',
        'property_id' => 'integer'
    ];

    public static array $rules = [
        'url' => 'required',
        'property_id' => 'required'
    ];

    
}
