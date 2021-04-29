<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Mockery\MockInterface;
use Tipoff\LaravelSerpapi\Helpers\SerpApiSearch;
use Tipoff\Seo\Jobs\GetLocalResults;
use Tipoff\Seo\Jobs\GetOrganicResults;
use Tipoff\Seo\Jobs\GetVideoResults;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\SearchLocale;
use Tipoff\Seo\Tests\TestCase;

class CheckRankingCommandTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_pull_keywords()
    {
        Bus::fake([
            GetOrganicResults::class,
            GetLocalResults::class,
            GetVideoResults::class
        ]);

        $serpApiSearch = $this->partialMock(
            SerpApiSearch::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('set_serp_api_key')
                    ->once()
                    ->withAnyArgs();

                $mock->shouldReceive('search')
                    ->once()
                    ->andReturn('test');
            }
        );
        $this->instance(SerpApiSearch::class, $serpApiSearch);

        $keyword = Keyword::factory()->create();
        $searchLocale = SearchLocale::factory()->create();
        $keyword->searchLocales()
                ->attach($searchLocale->id, [
                    'creator_id' => $searchLocale->creator_id,
                    'updater_id' => $searchLocale->updater_id
                ]);

        $this->artisan('pull:check_rankings')
            ->assertExitCode(0);

        $this->assertDatabaseCount('rankings', 1);

        Bus::assertChained([
            GetOrganicResults::class,
            GetLocalResults::class,
            GetVideoResults::class
        ]);
    }
}
