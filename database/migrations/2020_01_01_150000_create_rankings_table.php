<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\Webpage;

class CreateRankingsTable extends Migration
{
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->string('engine')->index(); // Example: 'google', 'bing' (haha)
            $table->string('provider')->index(); // Example: 'serpapi', 'moz', 'ahrefs'
            $table->foreignIdFor(Keyword::class)->index();
            $table->date('date')->index();

            // Results (Positions, Rankings, Organic Listings)
            // Relations to 10 webpages. Trying to decide naming conventions and how to handle rank 0
            $table->foreignIdFor(Webpage::class, 'position_01');
            $table->foreignIdFor(Webpage::class, 'position_02');
            $table->foreignIdFor(Webpage::class, 'position_03');
            $table->foreignIdFor(Webpage::class, 'position_04');
            $table->foreignIdFor(Webpage::class, 'position_05');
            $table->foreignIdFor(Webpage::class, 'position_06');
            $table->foreignIdFor(Webpage::class, 'position_07');
            $table->foreignIdFor(Webpage::class, 'position_08');
            $table->foreignIdFor(Webpage::class, 'position_09');
            $table->foreignIdFor(Webpage::class, 'position_10');

            // Local Listings
            $table->foreignIdFor(Place::class, 'local_01')->nullable();
            $table->foreignIdFor(Place::class, 'local_02')->nullable();
            $table->foreignIdFor(Place::class, 'local_03')->nullable();

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // Probably not ever used here, but just in case it is a requested run
            $table->foreignIdFor(app('user'), 'updater_id')->nullable(); // THere may later be a few fields that are updatable, but most will be locked to not be editable
            $table->timestamps();

            $table->unique(['engine', 'provider', 'keyword_id', 'date']);
        });
    }
}
