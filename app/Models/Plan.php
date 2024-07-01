<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $table = 'plans';

    public $fillable = [
        'name',
        'users',
        'website',
        'payment_method',
        'price'
    ];

    protected $casts = [
        'name' => 'string',
        'users' => 'integer',
        'payment_method' => 'string',
        'price' => 'integer'
    ];

    public static array $rules = [
        'name' => 'required',
        'users' => 'required',
        'website' => 'required',
        'payment_method' => 'required',
        'price' => 'requried'
    ];

    
}
