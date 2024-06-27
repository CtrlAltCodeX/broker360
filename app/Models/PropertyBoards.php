<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyBoards extends Model
{
    public $table = 'property_boards';

    public $fillable = [
        'name',
        'user_id',
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'user_id' => 'required'
    ];
}
