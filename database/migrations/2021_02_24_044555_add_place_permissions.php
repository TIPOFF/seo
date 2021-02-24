<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddPlacePermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view places',
                         'create places',
                         'update places',
                         'view location places',
                         'create location places',
                         'update location places',
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
