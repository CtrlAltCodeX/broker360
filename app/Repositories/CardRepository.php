<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class CardRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'number',
        'name',
        'expiry',
        'cvv',
        'frequency'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Card::class;
    }
}
