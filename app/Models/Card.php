<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public $table = 'cards';

    public $fillable = [
        'number',
        'name',
        'expiry',
        'cvv',
        'frequency'
    ];

    protected $casts = [
        'number' => 'string',
        'name' => 'string',
        'expiry' => 'string',
        'cvv' => 'integer',
        'frequency' => 'string'
    ];

    public static array $rules = [
        'number' => 'required',
        'name' => 'required',
        'expiry' => 'required',
        'cvv' => 'required'
    ];

    
}
