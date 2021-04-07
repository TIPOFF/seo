<?php

declare(strict_types=1);

namespace Tipoff\Seo\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Tipoff\Seo\Models\Domain;
use Tipoff\Seo\Models\Result;
use Tipoff\Seo\Models\Webpage;

class GetVideoResults
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
        if (isset($this->response_data->inline_videos)) {
            foreach ($this->response_data->inline_videos as $key => $inline_video) {
                $subdomain = Webpage::getSubDomains($inline_video->link);

                $domain = Domain::firstOrCreate([
                     'name' => Webpage::getDomain($inline_video->link),
                     'tld' => Webpage::getTLD($inline_video->link),
                     'https' => Webpage::isHttps($inline_video->link),
                     'sub_domain' => $subdomain,
                     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                 ]);

                $webpage = Webpage::firstOrCreate([
                     'domain' => $domain->id,
                     'path' => Webpage::getUrlPath($inline_video->link),
                     'sub_domain' => $subdomain,
                     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                 ]);

                $result = new Result([
                     'ranking_id' => $this->ranking_id,
                     'type' => 'Inline Video',
                     'position' => $key++,
                     'search_locale_id' => $this->search_locale_id,
                 ]);
                $result->resultable()->associate($webpage);
                $result->save();
            }
        } else {
            throw new \Exception("Didn't get inline video results to parse.");
        }
    }
}
