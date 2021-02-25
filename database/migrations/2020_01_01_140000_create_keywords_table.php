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
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('phrase')->index()->unique();
            $table->string('type')->index();
            
            $table->foreignIdFor(Keyword::class, 'parent_id')->nullable();
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->timestamps();
        });
    }
}
