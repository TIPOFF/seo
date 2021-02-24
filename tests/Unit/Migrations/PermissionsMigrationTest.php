<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Tipoff\Seo\Tests\TestCase;

class PermissionsMigrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function permissions_seeded()
    {
        $this->assertTrue(Schema::hasTable('permissions'));

        $seededPermissions = app(Permission::class)->whereIn('name', [
            'view companies',
            'create companies',
            'update companies',
            'view location companies',
            'create location companies',
            'update location companies',
            'view keywords',
            'create keywords',
            'update keywords',
            'view location keywords',
            'create location keywords',
            'update location keywords',
            'view domains',
            'create domains',
            'update domains',
            'view location domains',
            'create location domains',
            'update location domains',
            'view places',
            'create places',
            'update places',
            'view location places',
            'create location places',
            'update location places',
        ])->pluck('name');

        $this->assertCount(24, $seededPermissions);
    }
}
