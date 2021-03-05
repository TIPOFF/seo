<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Webpage extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function domain()
    {
        return $this->belongsTo(app('domain'));
    }

    public function rankings()
    {
        return $this->hasMany(app('ranking'));
    }
}
