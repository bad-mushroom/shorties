<?php

use App\Http\Controllers;
use App\Jobs\TrackLinkUsage;
use App\Services\Shorty\Facades\Shorty;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// -- Application Routes

Route::get('/', [Controllers\WebController::class, 'index'])
    ->name('app.index');

Route::get('/analytics', [Controllers\WebController::class, 'analytics'])
    ->name('app.analytics.index');

Route::post('/upload', [Controllers\WebController::class, 'upload'])
    ->name('app.upload.store');

// -- Where the Magic Happens

/**
 * We need to redirect the user to the long URL, but we also want to track
 * analytics on the link. We'll dispatch a job to do this so we don't slow
 * down the user's experience - or worse - if something goes wrong with the
 * analytics service, we don't want to break the user's experience.
 *
 * @param string $shortCode
 */
Route::get('{shortCode}', function (string $shortCode) {
    $url = Shorty::lookup($shortCode);

    TrackLinkUsage::dispatch($url->id, [
        'user_agent' => request()->userAgent(),
        'visit_date' => Carbon::now(),
    ]);

    return redirect($url->long_url);
});
