<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table = 'tasks';

    public $fillable = [
        'desc',
        'date',
        'time',
        'assigned_to',
        'category',
        'link'
    ];

    protected $casts = [
        'desc' => 'string',
        'date' => 'date',
        'assigned_to' => 'integer',
        'category' => 'string',
        'link' => 'string'
    ];

    public static array $rules = [
        'date' => 'required',
        'time' => 'required',
        'assigned_to' => 'required',
        'category' => 'required'
    ];

    
}
