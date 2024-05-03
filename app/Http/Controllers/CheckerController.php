<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCheckerProxiesRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckerController extends Controller
{
    public function __construct(

    ) {

    }

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
    public function create(CreateCheckerProxiesRequest $request)
    {
        Log::error($request->all());
        $data = $request->validated();

        return redirect();
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
