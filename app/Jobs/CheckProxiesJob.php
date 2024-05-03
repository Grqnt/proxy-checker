<?php

namespace App\Jobs;

use App\Contracts\Services\CheckProxyServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckProxiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $proxies;

    public function __construct($proxies)
    {
        $this->proxies = $proxies;
    }

    public function handle(
        CheckProxyServiceContract $checker
    )
    {
        $checker->checkProxies($this->proxies);

    }
}
