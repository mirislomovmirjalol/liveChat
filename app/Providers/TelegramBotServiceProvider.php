<?php

namespace App\Providers;

use App\TelegramBot;
use Illuminate\Support\ServiceProvider;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TelegramBot::class, function () {
            $token = config('services.telegram.token');
            $tbot = new TelegramBot($token);
            return $tbot;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
