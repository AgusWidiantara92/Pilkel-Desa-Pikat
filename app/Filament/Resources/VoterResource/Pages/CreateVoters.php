<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVoters extends CreateRecord
{
    protected static string $resource = VoterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
