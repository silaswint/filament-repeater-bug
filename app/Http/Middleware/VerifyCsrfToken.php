<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'livewire/*', // todo: this is BAD! see: https://stackoverflow.com/questions/76293041/why-i-get-alert-this-page-has-expired-in-laravel-livewire-upon-logging-back
    ];
}
