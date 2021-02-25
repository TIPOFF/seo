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

    const TYPE_BRANDED = 'Branded';
    const TYPE_GENERIC = 'Generic';
    const TYPE_LOCAL = 'Local';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($keyword) {
            $keyword->phrase = strtolower($keyword->phrase);
        });
    }

    public function isBranded(): bool
    {
        return $this->type == Keyword::TYPE_BRANDED;
    }

    public function isGeneric(): bool
    {
        return $this->type == Keyword::TYPE_GENERIC;
    }

    public function isLocal(): bool
    {
        return $this->type == Keyword::TYPE_LOCAL;
    }
}
