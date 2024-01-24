<?php

namespace App\Jobs;

use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackLinkUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * Note we're only passing the URL's ID here instead of serializing the
     * entire URL model and and eager loaded relationships. This will
     * save us some space in our queue.
     *
     * @param Urstringl $urlId
     * @param array $payload
     */
    public function __construct(public string $urlId, public array $payload)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @todo Consider adding an error check if the URL "find" fails
     */
    public function handle(): void
    {
        Url::find($this->urlId)->analytics()->create([
            'fingerprint' => $this->payload['user_agent'],
            'visited_at'  => $this->payload['visit_date'],
        ]);
    }
}
