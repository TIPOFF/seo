<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class PlaceDetails extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($place_details) {
            if (empty($place_details->name)) {
                throw new \Exception('Place details must have a name.');
            }
            if (empty($place_details->place_id)) {
                throw new \Exception('Place details must belong to a place.');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function webpage()
    {
        return $this->belongsTo(Webpage::class);
    }
}
