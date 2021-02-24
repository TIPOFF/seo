<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Tests\TestCase;

class PlaceModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Place::factory()->create();
        $this->assertNotNull($model);
    }
}
