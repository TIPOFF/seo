<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Keyword;

class CreateKeywordsTable extends Migration
{
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->string('engine')->index(); // Example: 'google', 'bing' (haha)
            $table->string('provider')->index(); // Example: 'serpapi', 'moz', 'ahrefs'
            $table->foreignIdFor(Keyword::class)->index();
            $table->date('date')->index();

            // Results
            // Relations to 10 webpages. Trying to decide naming conventions and how to handle rank 0

            // Local Listings
            // Nullable relations to 3 places. Trying to decide naming conventions.

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // Probably not ever used here, but just in case it is a requested run
            $table->foreignIdFor(app('user'), 'updater_id')->nullable(); // THere may later be a few fields that are updatable, but most will be locked to not be editable
            $table->timestamps();
        });

        // Add a unique combination of engine, provider, keyword_id & date
    }
}
