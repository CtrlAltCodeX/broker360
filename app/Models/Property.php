<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $table = 'properties';

    public $fillable = [
        'type',
        'ad_type',
        'ad_desc',
        'operation_type',
        'show_price_ad',
        'bedroom',
        'bathrooms',
        'half_bath',
        'parking_lots',
        'construction',
        'year_construction',
        'number_plants',
        'number_floors',
        'monthly_maintence',
        'internal_key',
        'key_code',
        'street',
        'corner_with',
        'postal_code',
        'property_features',
        'share_commission',
        'commission_percent',
        'condition_sharing',
        'price',
        'longitude_latitude',
        'status',
        'user_id',
    ];

    protected $casts = [
        'type' => 'string',
        'ad_type' => 'string',
        'ad_desc' => 'string',
        'operation_type' => 'string',
        'show_price_ad' => 'integer',
        'bedroom' => 'string',
        'bathrooms' => 'string',
        'half_bath' => 'string',
        'parking_lots' => 'string',
        'construction' => 'string',
        'year_construction' => 'string',
        'number_plants' => 'integer'
    ];

    public static array $rules = [
        'type' => 'required',
        'ad_type' => 'required',
        'ad_desc' => 'required',
        'operation_type' => 'required',
        'show_price_ad' => 'required',
        'construction' => 'required',
        'number_plants' => 'required',
        'price' => 'required',
        'user_id' => 'required',
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
