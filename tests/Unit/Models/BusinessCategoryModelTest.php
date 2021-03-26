<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\BusinessCategory;
use Tipoff\Seo\Tests\TestCase;

class BusinessCategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = BusinessCategory::factory()->create();
        $this->assertNotNull($model);
    }
}
