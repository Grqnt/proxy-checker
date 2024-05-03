<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CheckProxyServiceContract;
use App\Http\Requests\CreateCheckerProxiesRequest;
use App\Jobs\CheckProxiesJob;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
        CreateCheckerProxiesRequest $request,
        CheckProxyServiceContract $checkProxyService,
    ): RedirectResponse
    {
        $data = $request->validated();

        // TODO: сделать синхронное создание архива в сервисе и только после этого запуск очереди из сервиса
        CheckProxiesJob::dispatch($data);
//        $archiveId = $checkProxyService->checkProxies($data['proxies']);

        return redirect()->route('archive', ['id' => $archiveId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('welcome');
    }

    public function status(Request $request)
    {

    }
}
