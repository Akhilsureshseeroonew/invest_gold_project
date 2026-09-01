<?php

namespace App\Filament\Resources\InterestRateSchemes\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InterestRateSchemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('title')->required()
                    ->helperText('Scheme name shown on the accordion header.'),
                TextInput::make('icon')
                    ->helperText('Sprite id for the header icon, e.g. coin, wallet, female, lock.'),
            ]),
            Textarea::make('note')->rows(2)
                ->helperText('Shown as a small disclaimer under this table.'),

            Section::make('Rate table')
                ->description('Every cell here is editable — replace the "X" placeholders with the official published figures.')
                ->schema([
                    TagsInput::make('columns')
                        ->helperText('Column headers, left to right — e.g. Scheme · Loan per gram · Interest p.a. · Tenure')
                        ->placeholder('Add header'),
                    Repeater::make('rows')
                        ->hiddenLabel()
                        ->simple(
                            TagsInput::make('cells')
                                ->placeholder('Add cell value, then Enter')
                                ->helperText('One value per column, in the same order as the headers above.')
                        )
                        ->addActionLabel('Add row')
                        ->reorderable()
                        ->defaultItems(0),
                ]),

            Grid::make(2)->schema([
                Toggle::make('is_active')->default(true),
                TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }
}
