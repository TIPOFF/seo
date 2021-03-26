<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\SearchVolume;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class SearchVolumePolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view search volumes', true);
        $this->assertTrue($user->can('viewAny', SearchVolume::class));

        $user = self::createPermissionedUser('view search volumes', false);
        $this->assertFalse($user->can('viewAny', SearchVolume::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     * @param string $permission
     * @param UserInterface $user
     * @param bool $expected
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $search_volume = SearchVolume::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $search_volume));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view search volumes', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view search volumes', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create search volumes', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create search volumes', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update search volumes', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update search volumes', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete search volumes', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete search volumes', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     * @param string $permission
     * @param UserInterface $user
     * @param bool $expected
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $search_volume = SearchVolume::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $search_volume));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
