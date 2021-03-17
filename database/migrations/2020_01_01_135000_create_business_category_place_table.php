<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessCategoryPlaceTable extends Migration
{
    public function up()
    {
        Schema::create('business_category_place', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Tipoff\Seo\Models\BusinessCategory::class);
            $table->foreignIdFor(app('place'));
            $table->timestamps();

            $table->unique(['business_category','place']);
        });

    }
}
