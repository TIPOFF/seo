<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\PlaceHours;
use Tipoff\Seo\Tests\TestCase;

class PlaceHoursModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = PlaceHours::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function get_place()
    {
        $place = Place::factory()->create();
        $placeHours = PlaceHours::factory()->create(['place_id' => $place->id]);

        $this->assertInstanceOf(BelongsTo::class, $placeHours->place());
        $this->assertEquals($place->getForeignKey(), $placeHours->place()->getForeignKeyName());
        $this->assertEquals('place_hours.id', $placeHours->place()->getQualifiedParentKeyName());

        $this->assertEquals($place->id, $placeHours->place->id);
        $this->assertEquals($place->name, $placeHours->place->name);
    }
}
