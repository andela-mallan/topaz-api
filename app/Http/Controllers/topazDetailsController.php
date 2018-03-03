<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class topazDetailsController extends Controller
{
    /**
     * Protect the routes that use this controller
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
}
