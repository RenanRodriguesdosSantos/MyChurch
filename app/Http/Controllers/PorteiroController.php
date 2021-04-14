<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PorteiroController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','porteiro']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('porteiro');
    }
}
