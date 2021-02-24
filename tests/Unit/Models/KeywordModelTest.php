<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Tests\TestCase;

class KeywordModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Keyword::factory()->create();
        $this->assertNotNull($model);
    }
}
