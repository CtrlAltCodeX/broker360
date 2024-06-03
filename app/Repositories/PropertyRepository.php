<?php

namespace App\Repositories;

use App\Models\Property;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PropertyRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
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
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Property::class;
    }
}
