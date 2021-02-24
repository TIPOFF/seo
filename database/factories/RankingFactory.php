<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Models\Webpage;

class RankingFactory extends Factory
{
    protected $model = Ranking::class;

    public function definition()
    {
        return [
            'engine'            => $this->faker->name,
            'provider'          => $this->faker->name,
            'keyword_id'        => Keyword::factory()->create()->id,
            'date'              => $this->faker->date('Y-m-D'),
            'position_01'       => randomOrCreate(Webpage::class),
            'position_02'       => randomOrCreate(Webpage::class),
            'position_03'       => randomOrCreate(Webpage::class),
            'position_04'       => randomOrCreate(Webpage::class),
            'position_05'       => randomOrCreate(Webpage::class),
            'position_06'       => randomOrCreate(Webpage::class),
            'position_07'       => randomOrCreate(Webpage::class),
            'position_08'       => randomOrCreate(Webpage::class),
            'position_09'       => randomOrCreate(Webpage::class),
            'position_10'       => randomOrCreate(Webpage::class),
            'creator_id'        => randomOrCreate(app('user')),
            'updater_id'        => randomOrCreate(app('user')),
        ];
    }
}
