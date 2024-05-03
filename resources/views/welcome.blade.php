<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <form action="{{ route('start_check_proxies') }}" @method('POST')>
                @csrf
                <textarea name="proxies" id="proxies" cols="30" rows="10"></textarea>
                <br>
                <button type="submit">Check</button>
            </form>
        </div>
    </body>
</html>
