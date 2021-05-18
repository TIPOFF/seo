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

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
    ];

    public static $group = 'SEO';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Name')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Serp ID')->rules('required'),
            Number::make('Google ID')->rules('required', 'max:10'),
            Number::make('Google Parent ID')->rules('required', 'max:10'),
            Text::make('Name')->rules('required')->sortable(),
            Text::make('Canonical Name')->rules('required')->sortable(),
            Text::make('Country Code')->rules('required')->sortable(),
            Text::make('Target Type')->rules('required')->sortable(),
            Number::make('Reach')->rules('required', 'max:10'),
            Number::make('Latitude')->step(0.000001)->nullable(),
            Number::make('Longitude')->step(0.000001)->nullable(),

            nova('keyword') ? BelongsToMany::make('Keyword', 'keywords', nova('keyword'))->sortable() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields()
        );
    }
}
