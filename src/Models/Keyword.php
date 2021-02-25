<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Keyword extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($keyword) {
            $keyword->phrase = strtolower($keyword->phrase);

            if (empty($keyword->keyword_type_id)) {
                throw new \Exception('A keyword must be belong to a keyword type.');
            }
        });
    }

    public function keyword_types()
    {
        return $this->belongsTo(app('keyword_types'));
    }

}
