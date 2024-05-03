<?php

namespace App\Contracts\Repositories;

interface ArchiveRepositoryContract
{
    public function getAllProxies(string $id);

    public function checkerStatus(): array;
}
