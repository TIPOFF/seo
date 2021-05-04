<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Jobs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Jobs\GetVideoResults;
use Tipoff\Seo\Models\SearchLocale;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Tests\TestCase;

class GetVideoResultsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function cannot_get_inline_video_results_to_parse()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Didn't get inline video results to parse.");
        $getVideoResultsJob = new GetVideoResults(null, null, null);
        $getVideoResultsJob->handle();
    }

    /**
     * @test
     */
    public function get_video_results()
    {
        $search_locale = SearchLocale::factory()->create();
        $ranking = Ranking::factory()->create(['search_locale_id' => $search_locale->id]);
        $response_data = $this->getResponseData();

        $getVideoResultsJob = new GetVideoResults($response_data, $ranking->id, $search_locale->id);
        $getVideoResultsJob->handle();

        $this->assertDatabaseCount('domains', 1);
        $this->assertDatabaseCount('webpages', 1);
        $this->assertDatabaseCount('results', count($response_data->inline_videos));
    }

    /** @test */
    public function cannot_parse_video_results_url()
    {
        $search_locale = SearchLocale::factory()->create();
        $ranking = Ranking::factory()->create(['search_locale_id' => $search_locale->id]);
        $response_data = $this->getResponseDataWithBrokenLink();

        $getVideoResultsJob = new GetVideoResults($response_data, $ranking->id, $search_locale->id);
        $getVideoResultsJob->handle();

        $this->assertDatabaseCount('domains', 0);
        $this->assertDatabaseCount('webpages', 0);
        $this->assertDatabaseCount('results', 0);
    }

    protected function getResponseData()
    {
        return json_decode('{
          "inline_videos": [
            {
              "title": "Wiz Khalifa - Black And Yellow [Official Music Video]",
              "link": "https://www.youtube.com/watch?v=UePtoxDhJSw",
              "length": "3:52",
              "source": "YouTube - Wiz Khalifa",
              "date": "Oct 11, 2010",
              "block_position": 3
            },
            {
              "title": "Coldplay - Yellow",
              "link": "https://www.youtube.com/watch?v=1MwjX4dG72s",
              "length": "4:32",
              "source": "YouTube - emimusic",
              "date": "Mar 7, 2009",
              "block_position": 3
            },
            {
              "title": "Crazy Rich Asians Soundtrack - Yellow - Katherine Ho (Coldplay Cover)",
              "link": "https://www.youtube.com/watch?v=-6NQZHyJYO8",
              "length": "4:09",
              "source": "YouTube - WaterTower Music",
              "date": "Aug 10, 2018",
              "block_position": 3
            }
          ]
        }');
    }

    protected function getResponseDataWithBrokenLink()
    {
        return json_decode('{
          "inline_videos": [
            {
              "title": "Wiz Khalifa - Black And Yellow [Official Music Video]",
              "link": "https://brokenlink",
              "length": "3:52",
              "source": "YouTube - Wiz Khalifa",
              "date": "Oct 11, 2010",
              "block_position": 3
            }
          ]
        }');
    }
}
