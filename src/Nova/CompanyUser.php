<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class CompanyUser extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\CompanyUser::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Access';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Company', 'company.id', function () {
                return $this->company->name;
            }),
            Text::make('User', 'user.id', function () {
                return $this->user->full_name;
            }),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Boolean::make('Primary contact')
                ->rules('required'),
            nova('company') ? BelongsTo::make('Company', 'company', nova('company'))->searchable() : null,
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->searchable() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields(),
        );
    }
}
