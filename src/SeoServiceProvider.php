<?php

declare(strict_types=1);

namespace Tipoff\Seo;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SeoServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('seo')
            ->hasConfigFile();
    }
}
