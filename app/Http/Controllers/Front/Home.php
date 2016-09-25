<?php

namespace App\Http\Controllers\Front;

use App\Support\Asset;

class Home extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
