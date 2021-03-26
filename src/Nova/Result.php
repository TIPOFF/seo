<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;
use Tipoff\Seo\Enum\ResultType;

class Result extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\Result::class;

    public static $title = 'position';

    public static $search = [
        'id',
    ];

    public static $group = 'SEO';

    public static $displayInNavigation = false; //don't show resource in navigation

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Select::make('Type')->options([
                ResultType::ORGANIC_LISTING => 'Organic Listings',
                ResultType::LOCAL_LISTING => 'Local Listings',
                ResultType::FEATURED_SNIPPET => 'Featured Snippet',
                ResultType::INLINE_VIDEO_LISTINGS => 'Inline Video Listings',
                ResultType::ADS => 'Product',
            ])->required(),
            Number::make('Position')->required()->min(0)->max(255)->sortable(),

            nova('ranking') ? BelongsTo::make('Ranking', 'ranking', nova('ranking'))->sortable() : null,
            MorphTo::make('Resultable')->types([
                nova('place'),
                nova('webpage'),
            ]),


            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    public function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
        );
    }
}
