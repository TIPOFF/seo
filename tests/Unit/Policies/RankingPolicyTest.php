<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class RankingPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view rankings', true);
        $this->assertTrue($user->can('viewAny', Ranking::class));

        $user = self::createPermissionedUser('view rankings', false);
        $this->assertFalse($user->can('viewAny', Ranking::class));
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
        $ranking = Ranking::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $ranking));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view rankings', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view rankings', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create rankings', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create rankings', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update rankings', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update rankings', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete rankings', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete rankings', false), false ],
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
        $ranking = Ranking::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $ranking));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
