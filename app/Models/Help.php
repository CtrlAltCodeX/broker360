<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    public $table = 'helps';

    public $fillable = [
        'title',
        'desc'
    ];

    protected $casts = [
        'title' => 'string',
        'desc' => 'string'
    ];

    public static array $rules = [
        'title' => 'required',
        'desc' => 'required'
    ];

    
}
