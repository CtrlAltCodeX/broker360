<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PlanRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'name',
        'users',
        'website',
        'payment_method',
        'price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Plan::class;
    }
}
