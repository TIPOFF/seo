<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Place extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function results()
    {
        return $this->morphMany(Result::class, 'resultable');
    }
}
