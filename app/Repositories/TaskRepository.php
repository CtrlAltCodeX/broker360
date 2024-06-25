<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class TaskRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'desc',
        'date',
        'time',
        'assigned_to',
        'category',
        'link'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Task::class;
    }
}
