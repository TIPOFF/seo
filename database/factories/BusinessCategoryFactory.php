
<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Support\Enums\AppliesTo;
use Tipoff\Seo\Models\BusinessCategory;

class BusinessCategoryFactory extends Factory
{
    protected $model = BusinessCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
        ];
    }
}
