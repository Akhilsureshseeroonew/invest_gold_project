<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('name')->required()->columnSpanFull(),
                Textarea::make('address')->rows(2)->columnSpanFull(),
                TextInput::make('city'),
                TextInput::make('district'),
                TextInput::make('state')->default('Kerala'),
                TextInput::make('pincode'),
                TextInput::make('phone')->tel(),
                TextInput::make('email')->email(),
                TextInput::make('hours')->placeholder('Mon–Sat · 9:30 AM – 5:30 PM')->columnSpanFull(),
            ]),
            Section::make('Map')->columns(3)->collapsed()->schema([
                TextInput::make('latitude')->numeric(),
                TextInput::make('longitude')->numeric(),
                TextInput::make('maps_url')->label('Google Maps link')->url(),
            ]),
            Grid::make(2)->schema([
                Toggle::make('is_active')->default(true),
                TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }
}
