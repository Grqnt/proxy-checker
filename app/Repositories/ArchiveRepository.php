<?php

namespace App\Repositories;

use App\Contracts\Repositories\ArchiveRepositoryContract;
use App\Models\Archive;
use Illuminate\Database\Eloquent\Model;

class ArchiveRepository extends BaseRepository implements ArchiveRepositoryContract
{
    public function getModel(): Archive
    {
        return new Archive();
    }

    public function create(array $attributes): Model
    {
        return $this->getModel()->newQuery()
            ->create($attributes);
    }


    public function getById(string $id): ?Model
    {
        return $this->getModel()->newQuery()
            ->where('id', '=', $id)?->first();
    }

}
