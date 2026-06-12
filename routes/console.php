<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('subscription:expiry-notify')
    ->daily();

Schedule::command('report:weekly-registrations')
    ->weekly()
    ->mondays()
    ->at('17:00');

Schedule::command('notify:pending-verifications')
    ->hourly();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
