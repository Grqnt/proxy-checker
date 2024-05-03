<?php

namespace App\Http\Controllers;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('archives', []);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        //        $data =
        return view('welcome');
    }
}
