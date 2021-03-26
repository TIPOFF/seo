<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Seo\Enum\KeywordType;
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
        });
    }

    public function isBranded(): bool
    {
        return $this->type == KeywordType::BRANDED;
    }

    public function isGeneric(): bool
    {
        return $this->type == KeywordType::GENERIC;
    }

    public function isLocal(): bool
    {
        return $this->type == KeywordType::LOCAL;
    }
}
