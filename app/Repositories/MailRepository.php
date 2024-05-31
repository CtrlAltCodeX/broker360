<?php

namespace App\Repositories;

use App\Models\Mail;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class MailRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'to',
        'subject',
        'message'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Mail::class;
    }
}
