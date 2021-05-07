<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class PlaceDetails extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\PlaceDetails::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public static $group = 'SEO';

    public static $displayInNavigation = false; //don't show resource in navigation

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
            nova('place') ? BelongsTo::make('Place', 'place', nova('place'))->searchable() : null,
            Text::make('Name')->rules('required'),
            nova('domestic_address') ? BelongsTo::make('Domestic Address', 'domestic_address', nova('domestic_address'))->searchable()->nullable() : null,
            nova('phone') ? BelongsTo::make('Phone', 'phone', nova('phone'))->searchable()->nullable() : null,
            nova('webpage') ? BelongsTo::make('Webpage', 'webpage', nova('webpage'))->searchable()->nullable() : null,

            Date::make('Opened at')->nullable(),
            Number::make('Latitude')->step(0.000001)->nullable(),
            Number::make('Longitude')->step(0.000001)->nullable(),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
        );
    }
}
