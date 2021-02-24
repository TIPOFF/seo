<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\KeywordType;
use Tipoff\Seo\Tests\TestCase;

class KeywordTypeModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = KeywordType::factory()->create();
        $this->assertNotNull($model);
    }
}
