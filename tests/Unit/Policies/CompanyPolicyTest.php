<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class CompanyPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view companies', true);
        $this->assertTrue($user->can('viewAny', Company::class));

        $user = self::createPermissionedUser('view companies', false);
        $this->assertFalse($user->can('viewAny', Company::class));
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
        $company = Company::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $company));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view companies', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view companies', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create companies', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create companies', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update companies', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update companies', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete companies', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete companies', false), false ],
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
        $company = Company::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $company));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
