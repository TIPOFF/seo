<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class SearchLocale extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function keywords()
    {
        return $this->belongsToMany(app('keywords'))->withTimestamps();
    }

    public function rankings()
    {
        return $this->hasMany(app('ranking'));
    }
}
