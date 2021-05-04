<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\PlaceDetails;
use Tipoff\Seo\Models\Webpage;
use Tipoff\Seo\Tests\TestCase;

class PlaceDetailsModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = PlaceDetails::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function get_place()
    {
        $place = Place::factory()->create();
        $placeDetail = PlaceDetails::factory()->create(['place_id' => $place->id]);

        $this->assertInstanceOf(BelongsTo::class, $placeDetail->place());
        $this->assertEquals($place->getForeignKey(), $placeDetail->place()->getForeignKeyName());
        $this->assertEquals('place_details.id', $placeDetail->place()->getQualifiedParentKeyName());

        $this->assertEquals($place->id, $placeDetail->place->id);
        $this->assertEquals($place->name, $placeDetail->place->name);
    }

    /** @test */
    public function get_webpage()
    {
        $webpage = Webpage::factory()->create();
        $placeDetail = PlaceDetails::factory()->create(['webpage_id' => $webpage->id]);

        $this->assertInstanceOf(BelongsTo::class, $placeDetail->webpage());
        $this->assertEquals($webpage->getForeignKey(), $placeDetail->webpage()->getForeignKeyName());
        $this->assertEquals('place_details.id', $placeDetail->webpage()->getQualifiedParentKeyName());

        $this->assertEquals($webpage->id, $placeDetail->webpage->id);
        $this->assertEquals($webpage->path, $placeDetail->webpage->path);
    }
}
