<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddCompanyPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view companies',
                         'create companies',
                         'update companies',
                         'view location companies',
                         'create location companies',
                         'update location companies',
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
