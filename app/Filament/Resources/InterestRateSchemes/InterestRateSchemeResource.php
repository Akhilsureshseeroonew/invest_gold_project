<?php

namespace App\Filament\Resources\InterestRateSchemes;

use App\Filament\Resources\InterestRateSchemes\Pages\CreateInterestRateScheme;
use App\Filament\Resources\InterestRateSchemes\Pages\EditInterestRateScheme;
use App\Filament\Resources\InterestRateSchemes\Pages\ListInterestRateSchemes;
use App\Filament\Resources\InterestRateSchemes\Schemas\InterestRateSchemeForm;
use App\Filament\Resources\InterestRateSchemes\Tables\InterestRateSchemesTable;
use App\Models\InterestRateScheme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InterestRateSchemeResource extends Resource
{
    protected static ?string $model = InterestRateScheme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;
    protected static string|\UnitEnum|null $navigationGroup = 'Collections';
    protected static ?int $navigationSort = 15;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Interest rate';
    protected static ?string $pluralModelLabel = 'Interest Rates';

    public static function form(Schema $schema): Schema
    {
        return InterestRateSchemeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterestRateSchemesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInterestRateSchemes::route('/'),
            'create' => CreateInterestRateScheme::route('/create'),
            'edit' => EditInterestRateScheme::route('/{record}/edit'),
        ];
    }
}
