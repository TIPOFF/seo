<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\PlaceDetails;
use Tipoff\Seo\Tests\TestCase;

class PlaceDetailsModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = PlaceDetails::factory()->create();
        $this->assertNotNull($model);
    }
}
