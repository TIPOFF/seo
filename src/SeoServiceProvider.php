<?php

declare(strict_types=1);

namespace Tipoff\Seo;

use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Policies\CompanyPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SeoServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Company::class => CompanyPolicy::class
            ])
            ->name('seo')
            ->hasConfigFile();
    }
}
