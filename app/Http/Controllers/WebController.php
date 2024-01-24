<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\Url;
use App\Services\Shorty\Facades\Shorty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebController extends Controller
{
    /**
     * Show the "landing" page
     *
     * @return void
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Process file uploads
     *
     * @todo Consider moving the processing of the CSV out of the controller
     * and into a service class or job (or both). Broadcast events could
     * be used to notify the user of the status of the upload.
     *
     * @param FileUploadRequest $request
     * @return void
     */
    public function upload(FileUploadRequest $request)
    {
        $file = $request->file('file');

        // We don't want to overwrite any existing files, so we'll
        // generate a UUID here to use as the filename.
        $filePath = $file->storeAs('uploads', Str::uuid() . '.csv');
        $csvRows = array_map('str_getcsv', file(storage_path('app/' . $filePath)));

        foreach ($csvRows as $row) {
            if (filter_var($row[0], FILTER_VALIDATE_URL) !== false) {
                $urls[] = Shorty::create($row[0]);
            } else {
                Log::warning('Invalid URL: ' . $row[0]);
            }
        }

        return redirect()
            ->route('app.analytics.index')
            ->with('success', 'Those URLs are looking good!')
            ->with('urls', $urls);
    }

    /**
     * Analytics page
     *
     * If the request to this route is expecting JSON, we'll return the
     * urls/analytics as a JSON response. Otherwise, return the view.
     * In the future we may move this to a proper API.
     *
     * @todo Paginate results
     * @return void
     */
    public function analytics(Request $request)
    {
        $urls = Url::get();

        if ($request->expectsJson()) {
            return response()->json($urls->toArray());
        }

        return view('analytics')
            ->with('urls', $urls);
    }
}
