<?php

namespace App\Filament\Resources\TpsResource\Pages;

use App\Filament\Resources\TpsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTps extends CreateRecord
{
    protected static string $resource = TpsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
