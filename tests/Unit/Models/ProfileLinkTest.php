<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\ProfileLink;
use Tipoff\Seo\Tests\TestCase;

class ProfileLinkTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = ProfileLink::factory()->create();
        $this->assertNotNull($model);
    }
}
