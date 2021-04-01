<?php

declare(strict_types=1);

namespace Tipoff\Seo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use SerpApiSearch;
use Tipoff\Seo\Jobs\GetLocalResults;
use Tipoff\Seo\Jobs\GetOrganicResults;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Models\SearchLocale;

class CheckRankings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:check_rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull data with all keywords we have in keywords table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keywords = Keyword::all(); // gets only currently active keywords

        $serp_api = app()->make(SerpApiSearch::class);

        foreach ($keywords as $keyword) {
        	// each keyword could belong to multiple search locales
        	$keyword_search_locales = $keyword->searchLocales()->get();

			foreach ($keyword_search_locales as $search_locale){
				$query = [
					  "q" => $keyword->phrase,
					  "hl" => "en",
					  "gl" => "us",
					  "ludocid" => $search_locale->google_id
				];
				$response_data = $serp_api->search('json', $query);

				// create a new ranking per keyword-search_locale combination
				$ranking = new Ranking([
					'engine' => "google",
					'provider' => "serpapi",
					'keyword_id' => $keyword->id,
					'search_locale_id' => $search_locale->id,
					'date' => Carbon::now()->format('Y-m-d H:i:s'),
				]);
				$ranking->save();

				Bus::chain([
					new GetOrganicResults($response_data, $ranking->id, $search_locale->id),
					new GetLocalResults($response_data, $ranking->id, $search_locale->id, $keyword->phrase)
				])->dispatch();
			}
        }
    }
}
