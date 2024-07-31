<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $fillable = [
        'real_estate',
        'publish_property',
        'website',
        'user_id',
        'plan_id'
    ];

    public static array $rules = [
        'real_estate' => 'required',
        'publish_property' => 'required',
        'website' => 'required',
        'user_id' => 'required',
        'plan_id' => 'required'
    ];
}
