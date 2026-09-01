<?php

namespace App\Filament\Resources\InterestRateSchemes\Pages;

use App\Filament\Resources\InterestRateSchemes\InterestRateSchemeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInterestRateScheme extends EditRecord
{
    protected static string $resource = InterestRateSchemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
