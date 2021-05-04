<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Actions\Keywords\CheckRanking;
use Tipoff\Seo\Enum\KeywordType;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Models\SearchLocale;
use Tipoff\Seo\Models\SearchVolume;
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

    /** @test */
    public function get_rankings()
    {
        $keyword = Keyword::factory()->create();
        $ranking = Ranking::factory()->create(['keyword_id' => $keyword->id]);

        $this->assertInstanceOf(HasMany::class, $keyword->rankings());
        $this->assertEquals('keyword_id', $keyword->rankings()->getForeignKeyName());
        $this->assertEquals('keywords.id', $keyword->rankings()->getQualifiedParentKeyName());

        $this->assertEquals($ranking->id, $keyword->rankings()->first()->id);
    }

    /** @test */
    public function get_search_volume()
    {
        $keyword = Keyword::factory()->create();
        $volume = SearchVolume::factory()->create(['keyword_id' => $keyword->id]);

        $this->assertInstanceOf(HasOne::class, $keyword->searchVolume());
        $this->assertEquals('keyword_id', $keyword->searchVolume()->getForeignKeyName());
        $this->assertEquals('keywords.id', $keyword->searchVolume()->getQualifiedParentKeyName());

        $this->assertEquals($volume->id, $keyword->searchVolume->id);
    }

    /** @test */
    public function get_search_locales()
    {
        $keyword = Keyword::factory()->create();
        $searchLocale = SearchLocale::factory()->create();

        $keyword->searchLocales()->attach($searchLocale->id, [
            'creator_id' => $keyword->creator_id,
            'updater_id' => $keyword->updater_id,
        ]);

        $this->assertInstanceOf(BelongsToMany::class, $keyword->searchLocales());
        $this->assertEquals('keyword_search_locale.keyword_id', $keyword->searchLocales()->getQualifiedForeignPivotKeyName());
        $this->assertEquals('keyword_search_locale.search_locale_id', $keyword->searchLocales()->getQualifiedRelatedPivotKeyName());

        $this->assertEquals($searchLocale->id, $keyword->searchLocales()->first()->id);
    }

    /** @test */
    public function get_ranking()
    {
        $spy = $this->spy(CheckRanking::class);

        $keyword = Keyword::factory()->create();
        $keyword->getRanking();

        $spy->shouldHaveReceived('__invoke');
    }
}
