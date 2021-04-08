<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Webpage extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\Webpage::class;

    public static $title;

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
            Text::make('Path')->required(),
            Text::make('Subdomain')->nullable(),

            nova('domain') ? BelongsTo::make('Domain', 'domain', nova('domain'))->nullable() : null,
            app('video') ? BelongsTo::make('Video', 'video', app('video'))->nullable() : null,
            MorphMany::make('Results'),

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
