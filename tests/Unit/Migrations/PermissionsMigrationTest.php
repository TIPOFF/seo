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
        ])->pluck('name');

        $this->assertCount(6, $seededPermissions);
    }
}
