<?php

use App\Services\Demo\OccupancySimulatorService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    app(OccupancySimulatorService::class)->simulate();
})->everyMinute();
