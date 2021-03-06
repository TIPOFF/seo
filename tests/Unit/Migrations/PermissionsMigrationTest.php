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
            'delete companies',
            'view domains',
            'create domains',
            'update domains',
            'view webpages',
            'create webpages',
            'update webpages',
            'view places',
            'create places',
            'update places',
            'view profile links',
            'create profile links',
            'update profile links',
            'delete profile links',
            'view keywords',
            'create keywords',
            'update keywords',
            'delete keywords',
            'view rankings',
            'create rankings',
            'update rankings',
            'delete rankings',
            'view search volumes',
            'create search volumes',
            'update search volumes',
            'delete search volumes',
        ])->pluck('name');

        $this->assertCount(29, $seededPermissions);
    }
}
