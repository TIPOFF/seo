<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class KeywordPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view keywords', true);
        $this->assertTrue($user->can('viewAny', Keyword::class));

        $user = self::createPermissionedUser('view keywords', false);
        $this->assertFalse($user->can('viewAny', Keyword::class));
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
        $keyword = Keyword::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $keyword));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view keywords', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view keywords', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create keywords', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create keywords', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update keywords', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update keywords', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete keywords', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete keywords', false), false ],
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
        $keyword = Keyword::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $keyword));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
