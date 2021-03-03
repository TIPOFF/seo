<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class CreatePermissionsMigration extends Migration
{
    public function createPermissions(Collection $permissions)
    {
        $adminRole = Role::findByName('Admin');

        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ($permissions as $permission) {
                app(Permission::class)::findOrCreate($permission, 'null');
                $adminRole->givePermissionTo($permission);
            }
        }
    }
}