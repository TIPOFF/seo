<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Jobs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Jobs\GetOrganicResults;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Tests\TestCase;

class GetOrganicResultsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function cannot_get_organic_results_to_parse()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Didn't get organic results to parse.");
        $getOrganicResultsJob = new GetOrganicResults(null, null);
        $getOrganicResultsJob->handle();
    }

    /**
     * @test
     */
    public function get_organic_results_sitelinks_inline()
    {
        $ranking = Ranking::factory()->create();
        $response_data = $this->getResponseDataSiteLinksInline();

        $getOrganicResultsJob = new GetOrganicResults($response_data, $ranking->id);
        $getOrganicResultsJob->handle();

        $this->assertDatabaseCount('domains', 2);
        $this->assertDatabaseCount('webpages', 5);
        $this->assertDatabaseCount('results', 6);
    }

    /**
     * @test
     */
    public function get_organic_results_sitelinks_expanded()
    {
        $ranking = Ranking::factory()->create();
        $response_data = $this->getResponseDataSiteLinksExpanded();

        $getOrganicResultsJob = new GetOrganicResults($response_data, $ranking->id);
        $getOrganicResultsJob->handle();

        $this->assertDatabaseCount('domains', 2);
        $this->assertDatabaseCount('webpages', 5);
        $this->assertDatabaseCount('results', 6);
    }

    /** @test */
    public function cannot_parse_organic_results_url()
    {
        $ranking = Ranking::factory()->create();
        $response_data = $this->getResponseDataWithBrokenLink();

        $getOrganicResultsJob = new GetOrganicResults($response_data, $ranking->id);
        $getOrganicResultsJob->handle();

        $this->assertDatabaseCount('domains', 0);
        $this->assertDatabaseCount('webpages', 0);
        $this->assertDatabaseCount('results', 0);
    }

    protected function getResponseDataSiteLinksInline()
    {
        return json_decode('{
            "organic_results": [
                {
                    "position": 1,
                    "title": "Coffee Match Quiz | Blue Bottle Coffee",
                    "link": "https://bluebottlecoffee.com/match",
                    "displayed_link": "https://bluebottlecoffee.com › match",
                    "snippet": "Which brewing methods do you prefer at home...",
                    "sitelinks": {
                        "inline": [
                            {
                                "title": "Development and...",
                                "link": "https://en.wikipedia.org/wiki/Computer_Online_Forensic_Evidence_Extractor#Development_and_distribution"
                            },
                            {
                                "title": "Public leak",
                                "link": "https://en.wikipedia.org/wiki/Computer_Online_Forensic_Evidence_Extractor#Public_leak"
                            }
                        ]
                    }
                },
                {
                    "position": 2,
                    "title": "What`s Your Coffee Personality - Coffee Quiz - Bean Box",
                    "link": "https://beanbox.com/coffee-quiz",
                    "displayed_link": "https://beanbox.com › coffee-quiz",
                    "snippet": "Find out what types of coffee you like.",
                    "sitelinks": {
                        "inline": [
                            {
                                "title": "Stock caps",
                                "link": "https://www.cofee.eu/stock-caps"
                            },
                            {
                                "title": "Tailor made caps",
                                "link": "https://www.cofee.eu/tailor-made-caps"
                            }
                        ]
                    }
                }
            ]
        }');
    }

    public function getResponseDataSiteLinksExpanded()
    {
        return json_decode('{
            "organic_results": [
                {
                    "position": 1,
                    "title": "Apple",
                    "link": "https://www.apple.com/",
                    "displayed_link": "https://www.apple.com/",
                    "snippet": "Discover the innovative world of Apple and shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV, plus explore accessories, entertainment, and expert device support.",
                    "sitelinks_search_box": true,
                    "sitelinks": {
                        "expanded": [
                            {
                                "title": "iPhone",
                                "link": "https://www.apple.com/iphone/",
                                "snippet": "Explore iPhone, the world`s ..."
                            },
                            {
                                "title": "iPad",
                                "link": "https://www.apple.com/ipad/",
                                "snippet": "Compare iPad Models - iPad mini 4 - iPad Accessories - ..."
                            },
                            {
                                "title": "Mac",
                                "link": "https://www.apple.com/mac/",
                                "snippet": "MacBook Pro - MacBook - MacBook Air - iMac - Compare"
                            },
                            {
                                "title": "Music",
                                "link": "https://www.apple.com/music/",
                                "snippet": "Listen to your favorite music ad-free on all your devices, online ..."
                            },
                            {
                                "title": "Apple Support",
                                "link": "https://support.apple.com/",
                                "snippet": "Apple support is here to help. Learn more about popular ..."
                            },
                            {
                                "title": "Accessories",
                                "link": "https://www.apple.com/shop/accessories/all-accessories",
                                "snippet": "Shop Apple accessories for Apple Watch, iPhone, iPad, iPod, and ..."
                            }
                        ]
                    },
                    "cached_page_link": "https://webcache.googleusercontent.com/search?q=cache:xEELJvdODswJ:https://www.apple.com/+&cd=1&hl=en&ct=clnk&gl=us"
                }
            ]
        }');
    }

    protected function getResponseDataWithBrokenLink()
    {
        return json_decode('{
            "organic_results": [
                {
                    "position": 1,
                    "title": "Coffee Match Quiz | Blue Bottle Coffee",
                    "link": "https://brokenlink",
                    "displayed_link": "https://bluebottlecoffee.com › match",
                    "snippet": "Which brewing methods do you prefer at home? Select all that apply. French press. Coffee maker. Pour over. Chemex. Espresso. AeroPress. Cold brew. Other ."
                }
            ]
        }');
    }
}
