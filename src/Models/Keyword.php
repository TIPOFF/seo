<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Illuminate\Database\Eloquent\Builder;
use Tipoff\Seo\Enum\KeywordType;
use Tipoff\Seo\Services\Keyword\CheckRanking;
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

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', true);
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

    public function setActive($status = true) : self
    {
        if ($status === true) {
            $this->tracking_requested_at = now();
        } else {
            $this->tracking_stopped_at = now();
        }

        $this->is_active = $status;

        $this->save();

        return $this;
    }

    public function getRanking() : void
    {
        app(CheckRanking::class)($this);
    }

    public function searchLocales()
    {
        return $this->belongsToMany(app('search_locales'))->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo(app('keyword'), 'parent_id');
    }
}
