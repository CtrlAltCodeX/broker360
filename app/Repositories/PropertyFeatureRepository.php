<?php

namespace App\Repositories;

use App\Models\PropertyFeature;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PropertyFeatureRepository extends EloquentBaseRepository
{
    public function model(): string
    {
        return PropertyFeature::class;
    }
}
