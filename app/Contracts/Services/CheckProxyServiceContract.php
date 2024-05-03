<?php

namespace App\Contracts\Services;

use App\Contracts\Repositories\ProxyRepositoryContract;

interface CheckProxyServiceContract
{
    public function checkProxies(array $proxies): array;

    public function checkerStatus(string $archiveId): array;
}
