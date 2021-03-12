<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\SearchLocale;
use Tipoff\Seo\Tests\TestCase;

class SearchLocaleModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = SearchLocale::factory()->create();
        $this->assertNotNull($model);
    }
}
