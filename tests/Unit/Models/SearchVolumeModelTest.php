<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\SearchVolume;
use Tipoff\Seo\Tests\TestCase;

class SearchVolumeModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = SearchVolume::factory()->create();
        $this->assertNotNull($model);
    }
}
