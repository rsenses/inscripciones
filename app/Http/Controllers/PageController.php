<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function terminos()
    {
        return view('terminos');
    }

    public function politica()
    {
        return view('politica');
    }
}
