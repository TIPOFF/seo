<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyUser extends Pivot
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            foreach ($model->pivotParent->users()->allRelatedIds() as $id) {
            	$model->pivotParent->users()->sync([$id => [ 'primary_contact' => false] ], false);
            }  
        });
    }
}