<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\PlaceHours;
use Tipoff\Seo\Tests\TestCase;

class PlaceHoursModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = PlaceHours::factory()->create();
        $this->assertNotNull($model);
    }
}
