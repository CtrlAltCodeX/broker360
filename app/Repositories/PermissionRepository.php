<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Plan;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class PermissionRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'real_estate',
        'publish_property',
        'website',
        'user_id',
        'plan_id',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Permission::class;
    }
}
