<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Models\MenuItem;
use App\Models\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('menu')
                ->options(MenuItem::MENUS)
                ->default('header')
                ->required()
                ->native(false)
                ->live()
                ->helperText('Footer: top-level items are column headings, their children are the links under them.'),

            TextInput::make('label')->required(),

            Select::make('parent_id')
                ->label('Parent item')
                ->helperText('Leave empty for a top-level item. One level of nesting only.')
                ->options(fn ($record, $get) => MenuItem::query()
                    ->whereNull('parent_id')
                    ->where('menu', $get('menu') ?: 'header')
                    ->when($record, fn ($q) => $q->whereKeyNot($record->getKey()))
                    ->orderBy('sort_order')
                    ->pluck('label', 'id'))
                ->native(false)
                ->searchable(),

            Grid::make(2)->schema([
                Select::make('page_id')
                    ->label('Link to a page')
                    ->helperText('Pick a managed page…')
                    ->options(Page::query()->orderBy('title')->pluck('title', 'id'))
                    ->native(false)
                    ->searchable()
                    ->live(),
                TextInput::make('url')
                    ->label('…or a custom URL')
                    ->helperText('e.g. /calculator or https://wa.me/…')
                    ->disabled(fn ($get) => filled($get('page_id')))
                    ->dehydrated(),
            ]),

            Grid::make(3)->schema([
                Select::make('target')->options([
                    '_self'  => 'Same tab',
                    '_blank' => 'New tab',
                ])->default('_self')->native(false),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]),
        ]);
    }
}
