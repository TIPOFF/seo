<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class SearchLocale extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\SearchLocale::class;

    public static $title = 'serp_id';

    public static $search = [
        'id',
    ];

    public static $group = 'SEO';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Serp ID')->required(),
            Number::make('Google ID')->required(),
            Number::make('Google Parent ID')->required(),
            Text::make('Name')->required()->sortable(),
            Text::make('Canonical Name')->required()->sortable(),
            Text::make('Country Code')->required()->sortable(),
            Text::make('Target Type')->required()->sortable(),
            Number::make('Reach')->required(),
            Text::make('Latitude')->required(),
            Text::make('Longitude')->required(),

            nova('keyword') ? BelongsToMany::make('Keyword', 'keyword', nova('keyword'))->sortable() : null,

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
