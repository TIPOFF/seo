<?php

declare(strict_types=1);

namespace Tipoff\Seo\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Tipoff\Seo\Models\Result;
use Tipoff\Seo\Models\Webpage;

class GetOrganicResults
{
    use InteractsWithQueue;
    use Queueable;
    use Dispatchable;

    private $response_data;
    private $ranking_id;
    private $search_locale_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($responseData, $rankingId, $searchLocaleId)
    {
        $this->response_data = $responseData;
        $this->ranking_id = $rankingId;
        $this->search_locale_id = $searchLocaleId;
    }

    public function handle()
    {
        if (isset($this->response_data->organic_results)) {
            foreach ($this->response_data->organic_results as $organic_result) {
                $webpage = Webpage::firstOrCreate([
                     'domain' => Webpage::getDomain($organic_result->link),
                     'path' => Webpage::getPath($organic_result->link),
                     'sub_domain' => Webpage::getSubDomains($organic_result->link),
                     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                 ]);

                $result = new Result([
                     'ranking_id' => $this->ranking_id,
                     'type' => 'Organic',
                     'position' => $organic_result->position,
                     'search_locale_id' => $this->search_locale_id,
                 ]);
                $result->resultable()->associate($webpage);
                $result->save();
            }
        } else {
            throw new \Exception("Didn't get organic results to parse.");
        }
    }
}
