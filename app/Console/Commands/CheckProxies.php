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
    public function handle(
        CheckProxyServiceContract $checker
    ): void {
        if ($this->option('verbose')) {
            Log::info('Start...');
        }

        $this->info($this->description);

        //        $config = [
        //            'timeout'   => config('checker.timeout'),
        //            'check'     => ['get'],
        //        ];

        /*
        *	$url [required1]
        */
        //        $url = config('checker.url');

        $proxies = [
            '92.207.253.226:38157',
            //            'XXX.XXX.XXX.XXX:XXXX,username:password,Socks5',
            //            'XXX.XXX.XXX.XXX:XXXX'
        ];

        $result = $checker->checkProxies($proxies);

        $this->info(print_r($result));
        //        echo "<pre>";
        //        print_r($result);
        //        echo "</pre>";
        //        try {
        //        } catch (Exception $e) {
        //            $this->error($e->getMessage());
        //        }
    }
}
