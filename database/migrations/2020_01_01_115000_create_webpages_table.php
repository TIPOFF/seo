<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Domain;

class CreateDomainsTable extends Migration
{
    public function up()
    {
        Schema::create('webpages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Domain::class)->nullable();
            $table->string('path'); // Example: slug, folder/slug, folder/file.html, img/image-name.jpg

            $table->foreignIdFor(app('user'), 'creator_id')->nullable();
            $table->foreignIdFor(app('user'), 'updater_id')->nullable();
            $table->timestamps();
        });

        // Add a unique combination of domain_id & path
    }
}
