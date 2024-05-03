<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckProxies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-proxies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test check proxies';

    /**
     * Execute the console command.
     */
    public function handle(): void {
        if ($this->option('verbose')) {
            Log::info('Start...');
        }

        $this->info($this->description);

//        try {
//        } catch (Exception $e) {
//            $this->error($e->getMessage());
//        }
    }

}
