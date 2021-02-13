<?php

declare(strict_types=1);

namespace Tipoff\Seo;

use Tipoff\Seo\Models\Seo;
use Tipoff\Seo\Policies\SeoPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;


class SeoServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Seo::class => SeoPolicy::class,
            ])
            ->name('seo')
            ->hasConfigFile();
    }
}
