<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Support\Enums\AppliesTo;

class CreateDomainsTable extends Migration
{
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Eample: tipoff, drewroberts, google, amazon, wikipedia
            $table->string('tld'); // Example: com, org, net, co, dev
            $table->boolean('https')->default(true);

            // Add nullable company_id
            $table->foreignIdFor(app('user'), 'creator_id')->nullable();
            $table->foreignIdFor(app('user'), 'updater_id')->nullable();
            $table->timestamps();
        });

        // Add a unique combination of name & tld
    }
}
