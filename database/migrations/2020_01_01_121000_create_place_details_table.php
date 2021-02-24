<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Place;

class CreatePlaceDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('place_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Place::class);
            $table->string('name')->nullable();

            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // User that requested the place details to be updated
            $table->timestamp('created_at');
        });
    }
}
