<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $table = 'plans';

    public $fillable = [
        'name',
        'desc',
        'price'
    ];

    public static array $rules = [
        'name' => 'required',
        'desc' => 'required',
        'price' => 'required',
    ];

    public function permission()
    {
        return $this->hasMany(Permission::class);
    }
}
