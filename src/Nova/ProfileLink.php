<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class ProfileLink extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\ProfileLink::class;

    public static $orderBy = ['id' => 'asc'];

    public static $title = 'type';

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
            Text::make('type')->required(),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_filter([
            ID::make(),
        ]);
    }
}
