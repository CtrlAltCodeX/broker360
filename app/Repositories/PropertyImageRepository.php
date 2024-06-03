<?php

namespace App\Repositories;

use App\Models\PropertyImage;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PropertyImageRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'url',
        'property_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PropertyImage::class;
    }
}
