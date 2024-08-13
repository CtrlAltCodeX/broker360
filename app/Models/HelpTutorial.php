<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpTutorial extends Model
{
    public $table = 'help_tutorials';

    public $fillable = [
        'title',
        'link'
    ];

    protected $casts = [
        'title' => 'string',
        'link' => 'string'
    ];

    public static array $rules = [
        'title' => 'required',
        'link' => 'required'
    ];

    
}
