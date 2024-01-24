<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_url_is_redirected(): void
    {
        Url::factory()->create([
            'long_url'   => 'https://wemod.com',
            'short_code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertStatus(302);
        $response->assertRedirect('https://wemod.com');
    }
}
