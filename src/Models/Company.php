<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;
use Tipoff\Seo\Models\CompanyUser;

class Company extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function users()
    {
    	return $this->belongsToMany(app('user'))->withTimestamps()->withPivot(['creator_id','updater_id','primary_contact'])->using(CompanyUser::class);
    }
}
