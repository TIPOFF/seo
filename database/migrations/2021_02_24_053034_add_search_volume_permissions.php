<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddSearchVolumePermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view search volumes',
                         'create search volumes',
                         'update search volumes',
                         'view location search volumes',
                         'create location search volumes',
                         'update location search volumes',
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
