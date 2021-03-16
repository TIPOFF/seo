<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\PlaceDetails;

class PlaceDetailsFactory extends Factory
{
    protected $model = PlaceDetails::class;

    public function definition()
    {
        return [
            'name'                  => $this->faker->name,
            'opened_at'             => $this->faker->date,
            'latitude'              => $this->faker->latitude,
            'longitude'             => $this->faker->longitude,
            'webpage_id'            => randomOrCreate(app('webpage')),
            'place_id'              => randomOrCreate(app('place')),
            'domestic_address_id'   => randomOrCreate(app('domestic_address')),
            'creator_id'            => randomOrCreate(app('user')),
        ];
    }
}
