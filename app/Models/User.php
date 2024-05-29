<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'users';

    public $fillable = [
        'name',
        'email',
        'number',
        'identity',
        'country'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'number' => 'string',
        'identity' => 'integer',
        'country' => 'integer'
    ];

    public static array $rules = [
        'name' => 'required',
        'email' => 'required',
        'number' => 'required',
        'identity' => 'required',
        'country' => 'required'
    ];

    
}
