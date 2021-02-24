<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Keyword;

class CreateSearchVolumesTable extends Migration
{
    public function up()
    {
        Schema::create('search_volumes', function (Blueprint $table) {
            $table->id();
            $table->string('engine')->index(); // Example: 'google', 'bing' (haha)
            $table->string('provider')->index(); // Example: 'google search console', 'serpapi', 'moz', 'ahrefs'
            $table->foreignIdFor(Keyword::class)->index();
            $table->string('month')->index(); // Will probably use month integer for this. Will be first of the month through the last of the month.
            // May add other ranges for search volumes, like day and week if can get accurate data from google search console and if it is worth it

            $table->integer('queries');
            $table->integer('clicks')->nullable(); // For search console only

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // Probably not ever used here, but just in case it is a requested run
            $table->foreignIdFor(app('user'), 'updater_id')->nullable(); // There may later be a few fields that are updatable, but most will be locked to not be editable
            $table->timestamps();
        });

        // Add a unique combination of engine, provider, keyword_id & month
    }
}
