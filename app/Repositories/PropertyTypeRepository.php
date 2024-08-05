<?php

namespace App\Repositories;

use App\Models\PropertyBoards;
use App\Models\PropertyType;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PropertyTypeRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PropertyType::class;
    }
}
