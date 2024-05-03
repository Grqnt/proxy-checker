<?php

namespace App\Services;

use App\Contracts\Services\CheckProxyServiceContract;
use Exception;
use Illuminate\Support\Facades\Http;

class CheckProxyService implements CheckProxyServiceContract
{
    private mixed $checkUrl;

    private mixed $timeout;

    private mixed $client;

    //    private array $config = [
    //        'timeout'   => 100,
    //        'check'     => ['get', 'post', 'cookie', 'referer', 'user_agent'],
    //    ];

    public function __construct()
    {
        $this->checkUrl = config('checker.url');
        $this->timeout = config('checker.timeout');
    }

    //    public function setConfig(array $config): void
    //    {
    //        $this->config = array_merge($this->config, $config);
    //    }

    /**
     * Запуск проверки списка прокси
     */
    public function checkProxies(array $proxies): array
    {
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
    public function checkerStatus(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function checkProxy($proxy): array
    {
        [$content, $info] = $this->getProxyContent($proxy);

        return $this->checkProxyContent($content, $info);
    }

    private function getProxyContent(string $proxy): array
    {
        //        $client = new Http();
        //        Http::response()
        //        $client = new GuzzleHttp\Client();
        //        @list($proxyIp, $proxyType) = explode(',', $proxy);

        //        $url = $this->checkUrl;
        //        $ch = curl_init($url);

        // check query
        //        if (in_array('get', $this->config['check'])) {
        //            $url .= '';
        //        }

        $response = Http::withHeaders([
            CURLOPT_PROXY => $proxy,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_PROXYTYPE => CURLPROXY_HTTP,
        ])->get($this->checkUrl);
        Http::dd($response);
        dd($proxy);
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

        //        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);

        return [$content, $info];
    }

    /**
     * @throws Exception
     */
    private function checkProxyContent($content, $info): array
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

        return [
            'allowed' => $allowed,
            'disallowed' => $disallowed,
            'proxy_level' => $proxyLevel,
            'info' => $info,
        ];
    }
}
