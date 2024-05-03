<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProxyRepositoryContract;
use App\Models\Proxy;
use Illuminate\Database\Eloquent\Model;

class ProxyRepository extends BaseRepository implements ProxyRepositoryContract
{
    public function getModel(): Proxy
    {
        return new Proxy();
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
