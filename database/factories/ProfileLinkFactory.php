<?php

declare(strict_types=1);

namespace Tipoff\Seo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Models\ProfileLink;
use Tipoff\Seo\Models\Webpage;

class ProfileLinkFactory extends Factory
{
    protected $model = ProfileLink::class;

    public function definition()
    {
        return [
            'type'              => $this->faker->text,
            'profileable_id'    => randomOrCreate(Company::class),
            'profileable_type'  => 'company', // Will need to add models later to the factory.
            'webpage_id'        => randomOrCreate(Webpage::class),
            'creator_id'        => randomOrCreate(app('user')),
            'updater_id'        => randomOrCreate(app('user')),
        ];
    }
}
