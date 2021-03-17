<?php

declare(strict_types=1);

namespace Tipoff\Seo\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Keyword extends BaseResource
{
    public static $model = \Tipoff\Seo\Models\Keyword::class;

    public static $title = 'id';

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
            Text::make('Phrase')
                ->rules([
                    'required', 
                    'unique:keywords,phrase', 
                    function ($attribute, $value, $fail) {
                        if (strtolower($value) !== $value) {
                            return $fail('The '.$attribute.' field must be lowercase.');
                        }
                    }
                ])
                ->sortable(),
            Select::make('Type')->options([
                'Branded' => 'Branded',
                'Generic' => 'Generic',
                'Local' => 'Local',
            ])
                ->rules(['required'])
                ->sortable(),
            DateTime::make('Tracking Requested At')->nullable(),
            DateTime::make('Tracking Stopped At')->nullable(),

            nova('keyword') ? BelongsTo::make('Parent phrase', 'parent phrase', nova('keyword'))->nullable() : null,

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
