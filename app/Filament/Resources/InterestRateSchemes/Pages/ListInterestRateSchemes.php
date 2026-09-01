<?php

namespace App\Filament\Resources\InterestRateSchemes\Pages;

use App\Filament\Resources\InterestRateSchemes\InterestRateSchemeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterestRateSchemes extends ListRecords
{
    protected static string $resource = InterestRateSchemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
