<?php

namespace App\Contracts\Services;

interface CheckProxyServiceContract
{
    public function checkProxies(array $proxies): array;

    public function checkerStatus(): array;
}
