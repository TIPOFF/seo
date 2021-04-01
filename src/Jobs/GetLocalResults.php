<?php

declare(strict_types=1);

namespace Tipoff\Seo\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use SerpApiSearch;
use Tipoff\Addresses\Models\Country;
use Tipoff\Addresses\Models\CountryCallingcode;
use Tipoff\Addresses\Models\Phone;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\PlaceDetails;
use Tipoff\Seo\Models\PlaceHours;
use Tipoff\Seo\Models\Result;
use Tipoff\Seo\Models\Webpage;

class GetLocalResults
{
    use InteractsWithQueue;
    use Queueable;
    use Dispatchable;

    private $keyword;
    private $response_data;
    private $ranking_id;
    private $search_locale_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($responseData, $rankingId, $searchLocaleId, $keyword)
    {
        $this->keyword = $keyword;
        $this->response_data = $responseData;
        $this->ranking_id = $rankingId;
        $this->search_locale_id = $searchLocaleId;
    }

    public function handle()
    {
        if (isset($this->response_data->local_results) && isset($this->response_data->local_results->places)) {
            foreach ($this->response_data->local_results->places as $local_result) {
                $place = Place::where('place_location', $local_result->place_id)->first();
                if ($place == null) {
                    $company = new Company([
                        'name' => $local_result->title,
                        'slug' => Str::slug($local_result->title),
                        'domestic_address_id' => '', // TODO: some search results return address without city and zip e.g. 4553 Sherwood Way
                    ]);
                    $company->save();
                    $place = new Place([
                        'place_location' => $local_result->place_id,
                        'name' => $local_result->title,
                        'company_id' => $company->id,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                    $place->save();

                    $serp_api = app()->make(SerpApiSearch::class);

                    // query to get place address and hours
                    $query = [
                        "q" => $this->keyword,
                        "hl" => "en",
                        "gl" => "us",
                        "ludocid" => $local_result->place_id,
                        "tbm" => "lcl",
                    ];
                    $place_data = $serp_api->search('json', $query);

                    if (isset($place_data->local_results)) {
                        $searched_place = $place_data->local_results[0];
                        if (isset($searched_place->links->website)) {
                            $url = $searched_place->links->website;
                            $webpage = new Webpage([
                                 'domain' => Webpage::getDomain($url),
                                 'path' => Webpage::getPath($url),
                                 'sub_domain' => Webpage::getSubDomains($url),
                                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                             ]);
                            $webpage->save();
                        }

                        $country_id = Country::fromAbbreviation('US')->getId();
                        $country_calling_code = CountryCallingcode::where('country_id', $country_id)->first();
                        $phone = new Phone([
                            'country_callingcode_id' => $country_calling_code,
                            'full_number' => $searched_place->phone,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $phone->save();

                        $place_details = new PlaceDetails([
                            'place_id' => $local_result->place_id,
                            'name' => $local_result->title,
                            'webpage_id' => (isset($webpage->id)) ? $webpage->id : null,
                            'phone_id' => $phone->id,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $place_details->save();

                        // TODO: where do we get this info?
                        /*$place_hours = new PlaceHours([

                        ]);*/
                    }
                }

                $result = new Result([
                     'ranking_id' => $this->ranking_id,
                     'type' => 'Local',
                     'position' => $local_result->position,
                     'search_locale_id' => $this->search_locale_id,
                 ]);
                $result->resultable()->associate($place);
                $result->save();
            }
        }
    }
}
