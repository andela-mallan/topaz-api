<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * !!! Remember to delete when building front-end !!!
     *
     * @var array
     */
    protected $except = [
        '*/member/*',
        '*/contributions',
        '*/contribution/*',
        '*/meeting',
        '*/meeting/*',
        '*/investment',
        '*/investment/*'
    ];
}
