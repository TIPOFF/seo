<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SerpApiSearch;
use Tipoff\Addresses\Models\Region;
use Tipoff\Seo\Models\SearchLocale;

class PullSearchLocales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:search_locales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull all supported locations of the US in each DMA region';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $regions = Region::all();

        $serp_api = app()->make(SerpApiSearch::class);

        foreach ($regions as $region) {
            // @todo Needs Refactoring - how do we get more than 10 locations from serpapi?
            $locations_data = $serp_api->get_location($region->name, 10); // returns json response

            foreach ($locations_data as $location_data) {
                $search_locale = SearchLocale::where('google_id', $location_data->google_id)->first();

                if ($search_locale === null) {
                    $search_locale = new SearchLocale([
                        'serp_id' => $location_data->id,
                        'google_id' => $location_data->google_id,
                        'google_parent_id' => $location_data->google_parent_id,
                        'name' => $location_data->name,
                        'canonical_name' => $location_data->canonical_name,
                        'country_code' => $location_data->country_code,
                        'target_type' => $location_data->target_type,
                        'reach' => $location_data->reach,
                        'latitude' => $location_data->gps[0],
                        'longitude' => $location_data->gps[1],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                    $search_locale->save();
                }
            }
        }
    }
}
