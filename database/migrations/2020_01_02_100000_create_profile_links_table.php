<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Seo\Models\Webpage;

class CreateProfileLinksTable extends Migration
{
    public function up()
    {
        Schema::create('profile_links', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index(); // Example: 'Website', 'Facebook', 'Twitter', 'Instagram'
            $table->foreignIdFor(Webpage::class)->index();
            $table->morphs('profileable'); // Allows relations to User, Company, Location and other profiles that need links

            $table->unsignedTinyInteger('priority')->default(100); // For cases where want to list links in an order (by priority sorted ASC from low to high)

            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->timestamps();

            $table->unique(['type', 'profileable_id', 'profileable_type']);
        });
    }
}
