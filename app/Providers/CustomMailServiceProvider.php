<?php

namespace App\Providers;

use App\MailDriver\CustomMailManager;
use Illuminate\Mail\MailServiceProvider;

class CustomMailServiceProvider extends MailServiceProvider
{
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function($app) {
            return new CustomMailManager($app);
        });

        // Copied from Illuminate\Mail\MailServiceProvider
        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
