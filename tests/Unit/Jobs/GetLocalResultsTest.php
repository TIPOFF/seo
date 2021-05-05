<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Jobs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\LaravelSerpapi\Helpers\SerpApiSearch;
use Tipoff\Seo\Jobs\GetLocalResults;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Tests\TestCase;
use Mockery\MockInterface;

class GetLocalResultsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function cannot_get_local_results_to_parse()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Didn't get local results to parse.");
        $getLocalResultsJob = new GetLocalResults(null, null, null);
        $getLocalResultsJob->handle();
    }

    /**
     * @test
     */
    public function get_local_results()
    {
        $keyword = Keyword::factory()->create();
        $ranking = Ranking::factory()->create(['keyword_id' => $keyword->id]);
        $response_data = $this->getResponseDataLocalResults();

        $this->partialMock(
            SerpApiSearch::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('set_serp_api_key')
                    ->times(3)
                    ->withAnyArgs();

                $mock->shouldReceive('search')
                    ->times(3)
                    ->andReturn($this->getResponseDataPlaceResults());
            }
        );

        $getLocalResultsJob = new GetLocalResults($response_data, $ranking->id, $keyword->id);
        $getLocalResultsJob->handle();

        $this->assertDatabaseCount('place_hours', 3);
        $this->assertDatabaseCount('places', 3);
        $this->assertDatabaseCount('domains', 1);
        $this->assertDatabaseCount('webpages', 1);
        $this->assertDatabaseCount('countries', 1);
        $this->assertDatabaseCount('phones', 1);
        $this->assertDatabaseCount('companies', 3);
        $this->assertDatabaseCount('place_details', 3);
        $this->assertDatabaseCount('results', 3);
    }

    /** @test */
    public function get_local_results_without_place_results()
    {
        $keyword = Keyword::factory()->create();
        $ranking = Ranking::factory()->create(['keyword_id' => $keyword->id]);
        $response_data = $this->getResponseDataLocalResults();

        $this->partialMock(
            SerpApiSearch::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('set_serp_api_key')
                    ->times(3)
                    ->withAnyArgs();

                $mock->shouldReceive('search')
                    ->times(6)
                    ->andReturnNull();
            }
        );

        $getLocalResultsJob = new GetLocalResults($response_data, $ranking->id, $keyword->id);
        $getLocalResultsJob->handle();

        $this->assertDatabaseCount('place_hours', 0);
        $this->assertDatabaseCount('places', 3);
        $this->assertDatabaseCount('domains', 0);
        $this->assertDatabaseCount('webpages', 0);
        $this->assertDatabaseCount('countries', 1);
        $this->assertDatabaseCount('phones', 0);
        $this->assertDatabaseCount('companies', 3);
        $this->assertDatabaseCount('place_details', 3);
        $this->assertDatabaseCount('results', 3);
    }

    /** @test */
    public function get_local_results_with_place_results_broken_link()
    {
        $keyword = Keyword::factory()->create();
        $ranking = Ranking::factory()->create(['keyword_id' => $keyword->id]);
        $response_data = $this->getResponseDataLocalResults();

        $this->partialMock(
            SerpApiSearch::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('set_serp_api_key')
                    ->times(3)
                    ->withAnyArgs();

                $mock->shouldReceive('search')
                    ->times(3)
                    ->andReturn($this->getResponseDataPlaceResultsWithBrokenLink());
            }
        );

        $getLocalResultsJob = new GetLocalResults($response_data, $ranking->id, $keyword->id);
        $getLocalResultsJob->handle();

        $this->assertDatabaseCount('place_hours', 0);
        $this->assertDatabaseCount('places', 0);
        $this->assertDatabaseCount('domains', 0);
        $this->assertDatabaseCount('webpages', 0);
        $this->assertDatabaseCount('countries', 1);
        $this->assertDatabaseCount('phones', 0);
        $this->assertDatabaseCount('companies', 0);
        $this->assertDatabaseCount('place_details', 0);
        $this->assertDatabaseCount('results', 0);
    }

    protected function getResponseDataLocalResults()
    {
        return json_decode('{
            "local_results": {
                "places": [
                    {
                        "position": 1,
                        "title": "Roppolo’s Pizzeria",
                        "place_id": "14363647147486768618",
                        "lsig": "AB86z5W5p9_ndTaOi9QltGz45C_4",
                        "address": "316 E 6th St",
                        "gps_coordinates": {
                            "latitude": 30.26741,
                            "longitude": -97.7397
                        }
                    },
                    {
                        "position": 2,
                        "title": "DeSano Pizzeria Napoletana - Downtown Austin",
                        "place_id": "3865327066180748277",
                        "lsig": "AB86z5VVuEwjW5tRYc-Uey3hvZKy",
                        "address": "301 Lavaca St Suite 200",
                        "gps_coordinates": {
                            "latitude": 30.26616,
                            "longitude": -97.74587
                        }
                    },
                    {
                        "position": 3,
                        "title": "Spartan Pizza",
                        "place_id": "16265485598389531409",
                        "lsig": "AB86z5V5xZwTt-juOMieCn_QjLPJ",
                        "address": "1007 E 6th St · In Corazon Apartments",
                        "gps_coordinates": {
                            "latitude": 30.264896,
                            "longitude": -97.732285
                        }
                    }
                ]
            }
        }');
    }

    protected function getResponseDataPlaceResults()
    {
        return json_decode('{
           "place_results":{
              "title":"Stumptown Coffee Roasters",
              "address":"18 W 29th St, New York, NY 10001",
              "website":"https://www.stumptowncoffee.com/locations/newyork/ace-nyc",
              "phone":"(855) 711-3385",
              "hours":[
                 {
                    "tuesday":"8AM–3PM"
                 },
                 {
                    "wednesday":"8AM–3PM"
                 },
                 {
                    "thursday":"8AM–3PM"
                 },
                 {
                    "friday":"8–3PM"
                 },
                 {
                    "saturday":"Open 24 hours"
                 },
                 {
                    "sunday":"Closed"
                 },
                 {
                    "monday":"8AM–3PM"
                 }
              ]
           }
        }');
    }

    protected function getResponseDataPlaceResultsWithBrokenLink()
    {
        return json_decode('{
           "place_results":{
              "title":"Stumptown Coffee Roasters",
              "address":"18 W 29th St, New York, NY 10001",
              "website":"https://brokenlink",
              "phone":"(855) 711-3385",
              "hours":[
                 {
                    "tuesday":"8AM–3PM"
                 },
                 {
                    "wednesday":"8AM–3PM"
                 },
                 {
                    "thursday":"8AM–3PM"
                 },
                 {
                    "friday":"8–3PM"
                 },
                 {
                    "saturday":"Open 24 hours"
                 },
                 {
                    "sunday":"Closed"
                 },
                 {
                    "monday":"8AM–3PM"
                 }
              ]
           }
        }');
    }
}
