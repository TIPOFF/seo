<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\Result;
use Tipoff\Seo\Tests\TestCase;

class PlaceModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Place::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function get_results()
    {
        $place = Place::factory()->create();
        $results = Result::factory()->count(3)->create([
            'resultable_id' => $place->id,
            'resultable_type' => Place::class,
        ]);

        $place->results()->saveMany($results);

        $this->assertInstanceOf(MorphMany::class, $place->results());
        $this->assertEquals(Place::class, $place->results()->getMorphClass());
        $this->assertEquals('resultable_id', $place->results()->getForeignKeyName());
        $this->assertEquals('resultable_type', $place->results()->getMorphType());
        $this->assertEquals('places.id', $place->results()->getQualifiedParentKeyName());

        $this->assertCount($results->count(), $place->results()->get());
    }
}
