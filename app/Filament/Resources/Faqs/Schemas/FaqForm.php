<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('question')->required()->columnSpanFull(),
            RichEditor::make('answer')->required()->columnSpanFull()
                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList', 'undo', 'redo']),
            Grid::make(2)->schema([
                Toggle::make('is_published')->default(true),
                TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }
}
