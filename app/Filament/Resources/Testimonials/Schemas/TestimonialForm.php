<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('name')->required(),
                TextInput::make('location')->label('Location / role')->placeholder('Thrissur'),
            ]),
            Textarea::make('quote')->rows(4)->required()->columnSpanFull(),
            Grid::make(3)->schema([
                Select::make('rating')
                    ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'])
                    ->default(5)->required()->native(false),
                TextInput::make('avatar')->label('Avatar letter')->maxLength(1)
                    ->helperText('One letter shown in the circle. Defaults to the first letter of the name.'),
                TextInput::make('sort_order')->numeric()->default(0),
            ]),
            Toggle::make('is_published')->default(true),
        ]);
    }
}
