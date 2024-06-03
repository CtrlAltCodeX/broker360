<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class UserRepository extends EloquentBaseRepository
{
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'number',
        'identity',
        'country',
        'otp',
        'agency_name',
        'lang',
        'emails',
        'timezone',
        'profile_url',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }
}
