<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\KeywordType;

class KeywordTypeFactory extends Factory
{
    protected $model = KeywordType::class;

    public function definition()
    {
        return [
            'name'          => $this->faker->name,
            'slug'          => $this->faker->slug,
            'creator_id'    => randomOrCreate(app('user')),
            'updater_id'    => randomOrCreate(app('user')),
        ];
    }
}
