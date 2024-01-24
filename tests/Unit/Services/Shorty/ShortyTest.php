<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Services\Shorty\Shorty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortyTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate(): void
    {
        $shorty = new Shorty(6, 'https://shorty.test');
        $url = $shorty->create('qwerty');

        $this->assertStringContainsString('https://shorty.test', $url);
    }

    public function testCheckShortCode()
    {
        Url::factory()->create([
            'long_url'   => 'https://wemod.com',
            'short_code' => 'qwerty',
        ]);

        $shorty = new Shorty(6, 'https://shorty.test');

        $this->assertTrue($shorty->checkShortCode('qwerty'), 'Short code should already exist');
        $this->assertFalse($shorty->checkShortCode('asdfgh'), 'Short code should not exist');
    }
}
