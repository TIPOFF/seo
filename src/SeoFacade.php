<?php

namespace Tipoff\Seo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Seo\Seo
 */
class SeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seo';
    }
}
