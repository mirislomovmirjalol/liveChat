<?php

use App\TelegramBot;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tbot', function (TelegramBot $bot) {
    $bot->hears('salom', fn($bot) => $bot->reply('alik!'));
    $bot->hears('xayr', fn($bot) => $bot->reply('Xayr, kep turing!'));
    $bot->listen();
})->purpose('Handle Telegram bot updates');
