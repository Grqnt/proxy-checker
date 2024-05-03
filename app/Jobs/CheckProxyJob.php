<?php

namespace App\Jobs;

use App\DTOs\ProxyDTO;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CheckProxyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    public function __construct(
        private readonly ProxyDTO $proxyDTO,
    ) {
        $this->onQueue(config('queue.queues.check'));
    }

    public function handle(
    ): void {

        // TODO: Вызов команды через процесс start, проверка статуса

    }
}
