<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeginController extends Controller
{
    public function index()
    {
        return view('landing_page');
    }
}
