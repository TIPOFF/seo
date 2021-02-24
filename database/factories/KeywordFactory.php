<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\Keyword;

class KeywordFactory extends Factory
{
    protected $model = Keyword::class;

    public function definition()
    {
        return [
            'phrase'        => $this->faker->name,
            'creator_id'    => randomOrCreate(app('user')),
            'updater_id'    => randomOrCreate(app('user')),
        ];
    }
}
