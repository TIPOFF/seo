<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class PlaceHours extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;
    
    const UPDATED_AT = null;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($place_hours) {
            if (empty($place_hours->place_id)) {
                throw new \Exception('Place hours must belong to a place.');
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
