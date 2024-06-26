<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class User extends Authenticatable
{
    use SanctumHasApiTokens;

    public $table = 'users';

    public $fillable = [
        'name',
        'email',
        'password',
        'number',
        'identity',
        'country',
        'otp',
        'agency_name',
        'lang',
        'emails',
        'timezone',
        'profile_url',
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'number' => 'string',
    ];

    public static array $rules = [
        'name' => 'required',
        'email' => 'required',
        'number' => 'required',
    ];

    
}
