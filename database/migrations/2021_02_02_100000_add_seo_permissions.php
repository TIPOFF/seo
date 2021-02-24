<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddSeoPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                'view companies',
                'create companies',
                'update companies',
                'view domains',
                'create domains',
                'update domains',
                'view webpages',
                'create webpages',
                'update webpages',
                'view places',
                'create places',
                'update places',
                'view keyword types',
                'create keyword types',
                'update keyword types',
                'view keywords',
                'create keywords',
                'update keywords',
                'view rankings',
                'create rankings',
                'update rankings',
                'view search volumes',
                'create search volumes',
                'update search volumes',
            ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
