<?php

namespace App\Repositories;

use App\Models\Help;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class HelpRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'title',
        'desc'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Help::class;
    }
}
