<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class KeywordType extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($keyword_type) {
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keywords()
    {
        return $this->hasMany(app('keywords'));
    }
}
