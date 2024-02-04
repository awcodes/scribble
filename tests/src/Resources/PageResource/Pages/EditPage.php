<?php

namespace Awcodes\Scribble\Tests\Resources\PageResource\Pages;

use Awcodes\Scribble\Tests\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
