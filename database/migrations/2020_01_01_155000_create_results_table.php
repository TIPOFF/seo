<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Models\Webpage;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ranking::class)->index();
            $table->string('type')->index(); // Example: 'Organic', 'Local', 'Ads', 'Inline Video'
            $table->unsignedTinyInteger('position')->index();

            // resultable_id, resultable_type either Tipoff\Seo\Models\Webpage or Place
            $table->morphs('resultable');

            // Don't need timestamps since can use created_at timestamp of the ranking class

            $table->unique(['ranking_id', 'type', 'position']);
        });
    }
}
