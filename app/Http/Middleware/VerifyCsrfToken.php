<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/management/users/all',
        '/management/users/search',
        '/management/users/create',
        '/management/users/confirm/{token}',
        '/management/users/update/473',
        '/management/users/delete/474'
    ];
}
