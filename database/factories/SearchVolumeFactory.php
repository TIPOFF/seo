<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\SearchVolume;

class SearchVolumeFactory extends Factory
{
    protected $model = SearchVolume::class;

    public function definition()
    {
        return [
            'engine'            => $this->faker->name,
            'provider'          => $this->faker->name,
            'keyword_id'        => Keyword::factory()->create()->id,
            'month'             => $this->faker->month,
            'queries'           => $this->faker->randomNumber(),
            'clicks'            => $this->faker->randomNumber(),
            'creator_id'        => randomOrCreate(app('user')),
            'updater_id'        => randomOrCreate(app('user')),
        ];
    }
}
