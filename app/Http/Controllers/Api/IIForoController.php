<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IIForoController extends Controller
{
    public function streaming()
    {
        //
    }

    public function registrations()
    {
        //
    }
}

/*
 * La autenticación se realiza con dos métodos, un redirect a home si no se encuentra el localstorage del token
 * y además, los datos importantes se mandan por API
 */
