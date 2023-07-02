<?php

namespace App\Filament\Resources\TextWidgetResource\Pages;

use App\Filament\Resources\TextWidgetResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTextWidget extends EditRecord
{
    protected static string $resource = TextWidgetResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Text widget updated';
    }
}
