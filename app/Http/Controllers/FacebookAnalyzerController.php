<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookAnalyzerController extends Controller
{
    public function index()
    {
        return view('facebook-analyzer.index');
    }
}
