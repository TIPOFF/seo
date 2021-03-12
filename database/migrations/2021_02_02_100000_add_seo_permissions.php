<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSeoPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
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
            'view keywords' => ['Owner', 'Staff'],
            'create keywords' => ['Owner'],
            'update keywords' => ['Owner'],
            'view rankings' => ['Owner', 'Staff'],
            'create rankings' => ['Owner'],
            'update rankings' => ['Owner'],
            'view search volumes' => ['Owner', 'Staff'],
            'create search volumes' => ['Owner'],
            'update search volumes' => ['Owner'],
        ];

        $this->createPermissions($permissions);
    }
}
