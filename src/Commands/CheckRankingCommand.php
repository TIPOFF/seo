<?php

declare(strict_types=1);

namespace Tipoff\Seo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Tipoff\LaravelSerpapi\Helpers\SerpApiSearch;
use Tipoff\Seo\Jobs\GetLocalResults;
use Tipoff\Seo\Jobs\GetOrganicResults;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Services\Ranking\CheckAllKeywordRankings;

class CheckRankingCommand extends Command
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
        app(CheckAllKeywordRankings::class);
    }
}
