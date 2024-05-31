<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class ContactRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'name',
        'last_name',
        'position',
        'company',
        'fountain',
        'number',
        'email',
        'twitter',
        'linkedin',
        'skype',
        'website',
        'address',
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Contact::class;
    }
}
