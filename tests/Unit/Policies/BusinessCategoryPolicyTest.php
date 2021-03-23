<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\BusinessCategory;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class BusinessCategoryPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view business categories', true);
        $this->assertTrue($user->can('viewAny', BusinessCategory::class));

        $user = self::createPermissionedUser('view business categories', false);
        $this->assertFalse($user->can('viewAny', BusinessCategory::class));
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
        $business_category = BusinessCategory::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $business_category));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view business categories', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view business categories', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create business categories', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create business categories', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update business categories', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update business categories', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete business categories', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete business categories', false), false ],
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
        $business_category = BusinessCategory::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $business_category));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
