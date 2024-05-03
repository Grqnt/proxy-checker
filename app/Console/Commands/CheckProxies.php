<?php

namespace App\Console\Commands;

use App\Contracts\Services\CheckProxyServiceContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckProxies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-proxies {--proxy=}';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test check proxies';

    /**
     * Execute the console command.
     */
    public function handle(
        CheckProxyServiceContract $checker
    ): void {
        if ($this->option('verbose')) {
            Log::info('Start');
        }


//        72.10.160.170:2001
//        45.144.65.8:4444
//        47.88.3.19:8080
        $this->info($this->description);
        $result = $checker->checkProxy($this->option('proxy'));
//        dd($result);

    }
}
