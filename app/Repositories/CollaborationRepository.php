<?php

namespace App\Repositories;

use App\Models\Collaboration;
use App\Repositories\BaseRepository;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class CollaborationRepository extends EloquentBaseRepository
{
    public function model(): string
    {
        return Collaboration::class;
    }
}
