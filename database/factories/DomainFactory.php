<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Support\Enums\AppliesTo;
use Tipoff\Seo\Models\Domain;

class DomainFactory extends Factory
{
    protected $model = Domain::class;

    public function definition()
    {
        return [
            'creator_id'    => randomOrCreate(app('user')),
            'updater_id'    => randomOrCreate(app('user')),
        ];
    }
}
