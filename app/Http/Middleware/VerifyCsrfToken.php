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
        "api-register",
        "api-login",
        "api-logout",
        "api-get_user",
        "api-dashboard",
        "api-diary",
        "api-creatediary",
        "api-createpost/*",
        "api-editpost/*",
        "api-deletepost/*",
        "api-updateuser",
        "api-getpost/*"

    ];
}
