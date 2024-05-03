<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
    </head>

    <a href="/">На главную</a>

    <p>Статус проверки: {{ $status }}</p>

    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <table>
                <tr>
                    <th>ip:port</th>
                    <th>proxy type</th>
                    <th>country</th>
                    <th>status</th>
                    <th>timeout</th>
                    <th>real ip</th>
                </tr>
                @foreach($proxies as $proxy)
                    <tr>
                        <td>{{ $proxy['ip'] }}:{{ $proxy['port'] }}</td>
                        <td>{{ $proxy['type'] }}</td>
                        <td>{{ $proxy['country'] }}</td>
                        <td>{{ $proxy['status'] }}</td>
                        <td>{{ $proxy['timeout'] }}</td>
                        <td>{{ $proxy['realIp'] }}</td>
                    </tr>
                @endforeach
            </table>
            <p>Всего проверенных прокси: {{ count($proxies) }}</p>
            <p>Всего рабочих прокси: {{ $countActiveProxies }}</p>
        </div>
    </body>
</html>
