<?php

namespace App\Services;

use App\Contracts\Repositories\ProxyRepositoryContract;
use App\Contracts\Services\CheckProxyServiceContract;
use App\DTOs\ProxyDTO;
use App\Repositories\ProxyRepository;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckProxyService implements CheckProxyServiceContract
{
    private mixed $checkUrl;

    private mixed $timeout;

    private mixed $client;

    //    private array $config = [
    //        'timeout'   => 100,
    //        'check'     => ['get', 'post', 'cookie', 'referer', 'user_agent'],
    //    ];

    public function __construct(
        ProxyRepositoryContract $proxyRepository
    )
    {
        $this->checkUrl = config('checker.url');
        $this->timeout = config('checker.timeout');
        $this->proxyRepository = $proxyRepository;
    }

    //    public function setConfig(array $config): void
    //    {
    //        $this->config = array_merge($this->config, $config);
    //    }

    /**
     * Запуск проверки списка прокси,
     */
    public function checkProxies(array $proxies): array
    {
//        dd($proxies);
        $results = [];

        foreach ($proxies as $proxy) {

            try {
                if (! empty($proxy)) {
                    $results[$proxy] = $this->checkProxy($proxy);
                }
            } catch (Exception $e) {
                $results[$proxy]['error'] = $e->getMessage();
            }
        }

        return $results;
    }

    /**
     * Получение статуса проверки
     */
    public function checkerStatus(string $archiveId): array
    {
        return [];
    }

    /**
     * Проверка одного прокси
     * @throws Exception
     */
    public function checkProxy(string $proxy): bool
    {
        [$content, $info] = $this->getProxyContent($proxy);

        try {
            $this->proxyRepository->create(
                $this->checkProxyContent($content, $info),
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        return true;
    }

    private function getProxyContent(string $proxy): array
    {
        // TODO: логика парсинга данных из ответа

        //        $client = new Http();
        //        Http::response()
        //        $client = new GuzzleHttp\Client();
        //        @list($proxyIp, $proxyType) = explode(',', $proxy);

        $url = $this->checkUrl;
        $ch = curl_init($url);

        // check query
        //        if (in_array('get', $this->config['check'])) {
        //            $url .= '';
        //        }

//        $response = Http::withHeaders([
//            CURLOPT_PROXY => $proxy,
//            CURLOPT_HEADER => true,
//            CURLOPT_TIMEOUT => $this->timeout,
//            CURLOPT_CONNECTTIMEOUT => $this->timeout,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_PROXYTYPE => CURLPROXY_HTTP,
//        ])->get($this->checkUrl);
//        Http::dd($response);
//        dd($response);
        $options = [
            CURLOPT_PROXY => $proxy,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_PROXYTYPE => CURLPROXY_HTTP,
        ];

        //        if ( !empty($proxyIp) && !empty($proxyType) ) {
        //            if ( 'http'  ==  $proxyType )
        //                $options[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
        //            elseif ( 'Socks4'  ==  $proxyType )
        //                $options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS4;
        //            elseif ( 'Socks5'  ==  $proxyType )
        //                $options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5;
        //        }

        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);

//        dd($info['speed_download']);


        // $info['speed_download'] - время загрузки
        // $info['primary_ip'] - реальный ip

        dd($info);

        return [$content, $info];
    }

    /**
     * @throws Exception
     */
    private function checkProxyContent($content, $info): ProxyDTO
    {
        if (! $content) {
            throw new Exception('Empty content');
        }

        if (str_contains($content, 'check this string in proxy response content')) {
            throw new Exception('Wrong content');
        }

        if ($info['http_code'] !== 200) {
            throw new Exception('Code invalid: '.$info['http_code']);
        }

        $allowed = [];
        $disallowed = [];
        foreach ($this->config['check'] as $value) {

            if (str_contains($content, "allow_$value")) {
                $allowed[] = $value;
            } else {
                $disallowed[] = $value;
            }
        }

        // proxy level
        $proxyLevel = '';
        if (str_contains($content, 'proxylevel_elite')) {
            $proxyLevel = 'elite';
        } elseif (str_contains($content, 'proxylevel_anonymous')) {
            $proxyLevel = 'anonymous';
        } elseif (str_contains($content, 'proxylevel_transparent')) {
            $proxyLevel = 'transparent';
        }


        return new ProxyDTO();

        return [
            'allowed' => $allowed,
            'disallowed' => $disallowed,
            'proxy_level' => $proxyLevel,
            'info' => $info,
        ];
    }
}
