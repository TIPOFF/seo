<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\SearchLocale;

class CreateRankingsTable extends Migration
{
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->string('engine')->index(); // Example: 'google', 'youtube', 'bing' (haha)
            $table->string('provider')->index(); // Example: 'serpapi', 'moz', 'ahrefs'
            $table->foreignIdFor(Keyword::class)->index();
            $table->foreignIdFor(SearchLocale::class)->index();
            
            $table->date('date')->index();

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // Probably not ever used here, but just in case it is a requested run
            $table->foreignIdFor(app('user'), 'updater_id')->nullable(); // There may later be a few fields that are updatable, but most will be locked to not be editable
            $table->timestamps();

            $table->unique(['engine', 'provider', 'keyword_id', 'date']);
        });
    }
}
