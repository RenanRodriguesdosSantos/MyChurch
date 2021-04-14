<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObreiroController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','obreiro']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('obreiro');
    }
}
