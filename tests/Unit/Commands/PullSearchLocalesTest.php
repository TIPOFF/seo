<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\SearchLocale;
use Tipoff\Seo\Tests\TestCase;

class PullSearchLocalesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_pull_and_create_search_locales()
    {
        $this->artisan('pull:search_locales')
                ->assertExitCode(0);

        $this->assertNotCount(0, SearchLocale::get());
    }
}
