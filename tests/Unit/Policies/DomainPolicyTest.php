<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Domain;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class DomainPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view domains', true);
        $this->assertTrue($user->can('viewAny', Domain::class));

        $user = self::createPermissionedUser('view domains', false);
        $this->assertFalse($user->can('viewAny', Domain::class));
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
        $domain = Domain::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $domain));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view domains', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view domains', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create domains', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create domains', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update domains', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update domains', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete domains', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete domains', false), false ],
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
        $domain = Domain::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $domain));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
