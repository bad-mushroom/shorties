<?php

namespace App\Services\Shorty;

use App\Models\Url;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Shorty
{
    /**
     * The number of minutes to cache the short code lookup.
     *
     * @var int
     */
    public const CACHE_TTL_MINUTES = 60;

    /**
     * Create a new Shorty instance
     *
     * @param integer $shortCodeLength
     * @param string $shortCodePrefix
     */
    public function __construct(protected int $shortCodeLength, protected string $shortCodePrefix = '')
    {
        //
    }

    /**
     * Create a new short code for the given URL.
     *
     * @param string $fullUrl
     * @return string
     */
    public function create(string $fullUrl): string
    {
        do {
            $random = Str::lower(Str::random($this->shortCodeLength));
        } while ($this->checkShortCode($random));

        $shortUrl = Url::create([
            'long_url'   => $fullUrl,
            'short_code' => $random,
        ]);

        return $this->shortCodePrefix . '/' . $shortUrl->short_code;
    }

    /**
     * Lookup the long URL for the given short code. We want to minimize repeated
     * lookups for the same short code, so we'll cache the results for the
     * next time.
     *
     * @param string $shortCode
     * @return string
     */
    public function lookup(string $shortCode): Url
    {
        $url = Cache::remember($shortCode, self::CACHE_TTL_MINUTES, function () use ($shortCode) {
            return Url::query()
                ->where('short_code', $shortCode)
                ->firstOrFail();
        });

        return $url;
    }

    /**
     * Check if the given short code exists in the database.
     *
     * @param string $shortCode
     * @return boolean
     */
    public function checkShortCode(string $shortCode): bool
    {
        return Url::query()
            ->where('short_code', $shortCode)
            ->exists();
    }

    public function all(): array
    {
        return Url::all()->toArray();
    }

}
