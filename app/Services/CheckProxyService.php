<?php

namespace App\Services;

use App\Contracts\Repositories\ProxyRepositoryContract;
use App\Contracts\Services\CheckProxyServiceContract;
use App\DTOs\ProxyDTO;
use App\Repositories\ProxyRepository;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckProxyService implements CheckProxyServiceContract
{
    private mixed $checkUrl;
    private mixed $timeout;
    protected Client $client;

    public function __construct(
        ProxyRepositoryContract $proxyRepository
    )
    {
        $this->checkUrl = config('checker.url');
        $this->timeout = config('checker.timeout');
        $this->proxyRepository = $proxyRepository;
        $this->client = new Client();
    }

    /**
     * Запуск асинхронной проверки прокси
     */
    public function checkProxies(array $proxies): array
    {
        $requests = function ($proxies) {
            foreach ($proxies as $proxy) {
                yield new Request('GET', 'http://api.ipify.org', [
                    'proxy' => "http://{$proxy}"
                ]);
            }
        };

        $promises = (function () use ($requests, $proxies) {
            foreach ($requests($proxies) as $key => $request) {
                yield $this->client->sendAsync($request)->then(
                    function ($response) use ($key, $proxies) {
                        return [
                            'proxy' => $proxies[$key],
                            'ip' => $response->getBody()->getContents(),
                            'status' => 'working'
                        ];
                    },
                    function ($exception) use ($key, $proxies) {
                        return [
                            'proxy' => $proxies[$key],
                            'error' => $exception->getMessage(),
                            'status' => 'not working'
                        ];
                    }
                );
            }
        })();

        // TODO: переделать на ДТО
        $results = [];

        $eachPromise = new EachPromise($promises, [
            'concurrency' => 5,
            'fulfilled' => function ($result) use (&$results) {
                $results[] = $result;
            },
            'rejected' => function ($result) use (&$results) {
                $results[] = $result;
            }
        ]);
        $eachPromise->promise()->wait();

//        $this->saveProxyInfo($results);
        return $results;
    }

    /**
     * Получение статуса проверки
     */
    public function checkerStatus(string $archiveId): array
    {
        //TODO: Доделать получение статуса джобы
        return [];
    }

    /**
     * Сохранение прокси в БД, создание архива
     * @param $proxies
     * @return void
     */
    private function saveProxyInfo($proxies): void
    {
        foreach ($proxies as $proxy) {
            $this->proxyRepository->create([
                'ip' => $proxy['ip'],
                'port' => $proxy['port'],
                'status' => $proxy['status'],
            ]);
        }
    }

}
