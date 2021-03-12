<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class PlaceDetails extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\PlaceDetails::class;

    public static $title = 'name';

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
            Text::make('Name')->required(),
            Date::make('Opened at')->nullable(),
            Text::make('Address')->nullable(),
            Text::make('Address2')->nullable(),
            Text::make('City')->nullable(),
            Text::make('State')->nullable(),
            Text::make('Zip')->rules('max:5')->nullable(),
            Text::make('Phone')->rules('max:25')->nullable(),
            Text::make('Maps url')->nullable(),
            Text::make('Latitude')->nullable(),
            Text::make('Longitude')->nullable(),

            nova('place') ? BelongsTo::make('Place', 'place', nova('place'))->sortable() : null,
            nova('webpage') ? BelongsTo::make('Webpage', 'webpage', nova('webpage'))->nullable() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            [
                $this->creatorDataFields(),
            ]
        );
    }
}
