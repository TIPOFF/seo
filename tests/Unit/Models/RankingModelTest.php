<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Tests\TestCase;

class RankingModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Ranking::factory()->create();
        $this->assertNotNull($model);
    }
}
