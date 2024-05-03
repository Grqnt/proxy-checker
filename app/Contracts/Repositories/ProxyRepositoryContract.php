<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ProxyRepositoryContract
{
    public function create(array $attributes): Model;

    public function getById(string $id): ?Model;

}
