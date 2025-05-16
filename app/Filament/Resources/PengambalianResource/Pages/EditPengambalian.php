<?php

namespace App\Filament\Resources\PengambalianResource\Pages;

use App\Filament\Resources\PengambalianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengambalian extends EditRecord
{
    protected static string $resource = PengambalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
