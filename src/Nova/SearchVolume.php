<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class SearchVolume extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\SearchVolume::class;

    public static $title = 'engine';

    public static $search = [
        'id',
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Engine')->required()->sortable(),
            Text::make('Provider')->required()->sortable(),
            Text::make('Month')->required()->sortable(),
            Number::make('Queries')->required(),
            Number::make('Clicks')->nullable(),

            nova('keyword') ? BelongsTo::make('Keyword', 'keyword', nova('keyword'))->sortable() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            [
                $this->creatorDataFields(),
                $this->updaterDataFields(),
            ]
        );
    }
}
