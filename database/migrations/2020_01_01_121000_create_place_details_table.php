<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\Webpage;

class CreatePlaceDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('place_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Place::class);
            $table->string('name');
            $table->foreignIdFor(app('domestic_address'))->nullable();
            $table->string('phone', 25)->nullable();
            $table->foreignIdFor(Webpage::class)->nullable();
            $table->date('opened_at')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // User that requested the place data to be updated
            $table->timestamps();
        });
    }
}
