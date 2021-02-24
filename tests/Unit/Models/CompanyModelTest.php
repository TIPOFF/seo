<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Tests\TestCase;

class CompanyModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Company::factory()->create();
        $this->assertNotNull($model);
    }
}
