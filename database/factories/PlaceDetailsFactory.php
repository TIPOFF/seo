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
            'name'              => $this->faker->name,
            'phone'             => $this->faker->phone_number,
            'opened_at'         => $this->faker->date,
            'latitude'          => $this->faker->latitude,
            'longitude'         => $this->faker->longitude,
            'domain_id'         => randomOrCreate(app('webpage')),
            'place_id'          => randomOrCreate(app('place')),
            'domestic_address'  => randomOrCreate(app('domestic_address')),
            'creator_id'        => randomOrCreate(app('user')),
        ];
    }
}
