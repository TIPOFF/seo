<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests;

use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Seo\SeoServiceProvider;
use Tipoff\Addresses\AddressesServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AuthorizationServiceProvider::class,
            PermissionServiceProvider::class,
            SeoServiceProvider::class,
            AddressesServiceProvider::class,
        ];
    }
}
