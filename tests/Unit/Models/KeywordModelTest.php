<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Enum\KeywordType;
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

    /** @test */
    public function is_branded()
    {
        $keyword = Keyword::factory()->create(['type' => KeywordType::BRANDED]);
        $this->assertTrue($keyword->isBranded());
    }

    /** @test */
    public function is_generic()
    {
        $keyword = Keyword::factory()->create(['type' => KeywordType::GENERIC]);
        $this->assertTrue($keyword->isGeneric());
    }

    /** @test */
    public function is_local()
    {
        $keyword = Keyword::factory()->create(['type' => KeywordType::LOCAL]);
        $this->assertTrue($keyword->isLocal());
    }

    /** @test */
    public function get_parent()
    {
        $parentKeyword = Keyword::factory()->create();
        $keyword = Keyword::factory()->create(['parent_id' => $parentKeyword->id]);

        $this->assertInstanceOf(BelongsTo::class, $keyword->parent());
        $this->assertEquals('parent_id', $keyword->parent()->getForeignKeyName());
        $this->assertEquals('keywords.id', $keyword->parent()->getQualifiedParentKeyName());

        $this->assertEquals($parentKeyword->id, $keyword->parent->id);
        $this->assertEquals($parentKeyword->name, $keyword->parent->name);
    }
}
