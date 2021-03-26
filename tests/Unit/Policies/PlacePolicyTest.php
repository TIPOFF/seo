<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class PlacePolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view places', true);
        $this->assertTrue($user->can('viewAny', Place::class));

        $user = self::createPermissionedUser('view places', false);
        $this->assertFalse($user->can('viewAny', Place::class));
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
        $place = Place::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $place));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view places', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view places', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create places', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create places', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update places', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update places', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete places', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete places', false), false ],
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
        $place = Place::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $place));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
