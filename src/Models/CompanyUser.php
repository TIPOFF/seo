<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class CompanyUser extends Pivot
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public $incrementing = true;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Set previous contact is not primary if the current one is primary
            if ($model->primary_contact) {
                self::where('company_id', $model->company_id)
                    ->where('id', '!=', $model->id)
                    ->update(['primary_contact' => false]);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(app('company'));
    }

    public function user()
    {
        return $this->belongsTo(app('user'));
    }
}
