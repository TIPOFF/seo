<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Webpage;
use Tipoff\Seo\Tests\TestCase;

class WebpageModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Webpage::factory()->create();
        $this->assertNotNull($model);
    }
}
