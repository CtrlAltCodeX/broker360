<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $table = 'contacts';

    public $fillable = [
        'name',
        'last_name',
        'position',
        'company',
        'fountain',
        'number',
        'email',
        'twitter',
        'linkedin',
        'skype',
        'website',
        'address',
        'description',
        'user_id',
    ];

    protected $casts = [
        'name' => 'string',
        'last_name' => 'string',
        'position' => 'string',
        'company' => 'string',
        'fountain' => 'string',
        'number' => 'string',
        'email' => 'string',
        'twitter' => 'string',
        'linkedin' => 'string',
        'skype' => 'string',
        'website' => 'string',
        'address' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'number' => 'required',
        'email' => 'required',
        'twitter' => 'required',
        'user_id' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
