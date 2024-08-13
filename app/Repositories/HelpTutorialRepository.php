<?php

namespace App\Repositories;

use App\Models\Help;
use App\Models\HelpTutorial;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class HelpTutorialRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'title',
        'link'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return HelpTutorial::class;
    }
}
