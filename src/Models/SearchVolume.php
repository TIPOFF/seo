<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class SearchVolume extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($search_volume) {
            if (empty($search_volume->engine)) {
                throw new \Exception('Search Volume must have an engine.');
            }
            if (empty($search_volume->provider)) {
                throw new \Exception('Search Volume must have a provider.');
            }
            if (empty($search_volume->range)) {
                throw new \Exception('Search Volume must have a range of month, week or day.');
            }
            if (empty($search_volume->range_value)) {
                throw new \Exception('Search Volume must have a range value.');
            }
            if (empty($search_volume->queries)) {
                throw new \Exception('Search Volume must have queries.');
            }
            if (empty($search_volume->keyword_id)) {
                throw new \Exception('Search Volume must have a keyword.');
            }
        });
    }

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }
}
