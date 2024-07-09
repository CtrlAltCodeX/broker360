<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public $table = 'mails';

    public $fillable = [
        'to',
        'subject',
        'message',
        'file'
    ];

    protected $casts = [
        'to' => 'string',
        'subject' => 'string',
        'message' => 'string'
    ];

    public static array $rules = [
        'to' => 'required',
        'subject' => 'required',
        'message' => 'required'
    ];

    
}
