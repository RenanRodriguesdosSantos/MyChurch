<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','lider']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('lider');
    }
}
