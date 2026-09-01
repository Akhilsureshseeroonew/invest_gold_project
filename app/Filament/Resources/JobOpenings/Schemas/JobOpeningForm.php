<?php

namespace App\Filament\Resources\JobOpenings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class JobOpeningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $get, $set) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')->required()->rule('alpha_dash'),
                TextInput::make('department'),
                TextInput::make('location'),
                TextInput::make('employment_type')->placeholder('Full-time'),
                TextInput::make('experience')->placeholder('2–4 years'),
                TextInput::make('salary_range')->placeholder('₹4.2 – ₹6.5 LPA'),
            ]),
            Textarea::make('summary')->rows(2)->columnSpanFull(),
            RichEditor::make('description')->columnSpanFull(),

            Grid::make(3)->schema([
                Section::make('What you will do')->schema([
                    Repeater::make('responsibilities')->hiddenLabel()
                        ->simple(TextInput::make('item')->required())
                        ->addActionLabel('Add')->reorderable()->defaultItems(0),
                ]),
                Section::make('What we are looking for')->schema([
                    Repeater::make('requirements')->hiddenLabel()
                        ->simple(TextInput::make('item')->required())
                        ->addActionLabel('Add')->reorderable()->defaultItems(0),
                ]),
                Section::make('What we offer')->schema([
                    Repeater::make('benefits')->hiddenLabel()
                        ->simple(TextInput::make('item')->required())
                        ->addActionLabel('Add')->reorderable()->defaultItems(0),
                ]),
            ]),

            Section::make('Status')->columns(3)->schema([
                Toggle::make('is_open')->default(true),
                DatePicker::make('posted_at')->default(now()),
                DatePicker::make('closing_at'),
            ]),
        ]);
    }
}
