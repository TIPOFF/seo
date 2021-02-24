<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddDomainPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view domains',
                         'create domains',
                         'update domains',
                         'view location domains',
                         'create location domains',
                         'update location domains',
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
