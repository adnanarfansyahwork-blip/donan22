<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled Tasks
Schedule::call(function () {
    Log::info('Cron job running at ' . now());
})->everyMinute()->name('test-cron');

// Example: Clear old view cache daily
Schedule::command('view:clear')->daily()->at('02:00');

// Example: Generate sitemap weekly
// Schedule::command('sitemap:generate')->weekly()->sundays()->at('03:00');
