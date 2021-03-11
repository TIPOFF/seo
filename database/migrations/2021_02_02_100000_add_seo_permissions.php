<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSeoPermissions extends BasePermissionsMigration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                'view companies' => ['Owner', 'Staff'],
                'create companies' => ['Owner'],
                'update companies' => ['Owner'],
                'view domains' => ['Owner', 'Staff'],
                'create domains' => ['Owner'],
                'update domains' => ['Owner'],
                'view webpages' => ['Owner', 'Staff'],
                'create webpages' => ['Owner'],
                'update webpages' => ['Owner', 'Staff'],
                'view places' => ['Owner', 'Staff'],
                'create places' => ['Owner'],
                'update places' => ['Owner'],
                'view profile links' => ['Owner', 'Staff'],
                'create profile links' => ['Owner'],
                'update profile links' => ['Owner'],
                'delete profile links'=> [],
                'view keywords' => ['Owner', 'Staff'],
                'create keywords' => ['Owner'],
                'update keywords' => ['Owner'],
                'view rankings' => ['Owner', 'Staff'],
                'create rankings' => ['Owner'],
                'update rankings' => ['Owner'],
                'view search volumes' => ['Owner', 'Staff'],
                'create search volumes' => ['Owner'],
                'update search volumes' => ['Owner'],
            ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
