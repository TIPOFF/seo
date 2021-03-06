<?php

declare(strict_types=1);

namespace Tipoff\Seo;

use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Models\Domain;
use Tipoff\Seo\Models\Keyword;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Models\ProfileLink;
use Tipoff\Seo\Models\Ranking;
use Tipoff\Seo\Models\SearchVolume;
use Tipoff\Seo\Models\Webpage;
use Tipoff\Seo\Policies\CompanyPolicy;
use Tipoff\Seo\Policies\DomainPolicy;
use Tipoff\Seo\Policies\KeywordPolicy;
use Tipoff\Seo\Policies\PlacePolicy;
use Tipoff\Seo\Policies\ProfileLinkPolicy;
use Tipoff\Seo\Policies\RankingPolicy;
use Tipoff\Seo\Policies\SearchVolumePolicy;
use Tipoff\Seo\Policies\WebpagePolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SeoServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Company::class => CompanyPolicy::class,
                Keyword::class => KeywordPolicy::class,
                Domain::class => DomainPolicy::class,
                Place::class => PlacePolicy::class,
                ProfileLink::class => ProfileLinkPolicy::class,
                Ranking::class => RankingPolicy::class,
                SearchVolume::class => SearchVolumePolicy::class,
                Webpage::class => WebpagePolicy::class,
            ])
            ->name('seo')
            ->hasConfigFile();
    }
}
