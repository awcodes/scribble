<?php

namespace Awcodes\Scribble\Livewire;

use Awcodes\Pounce\Enums\Alignment;
use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Pounce\Enums\SlideDirection;
use Awcodes\Pounce\PounceComponent;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;

abstract class ScribbleModal extends PounceComponent implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?string $header = null;

    public static ?MaxWidth $maxWidth = null;

    public static ?Alignment $alignment = null;

    public static ?SlideDirection $slideDirection = null;

    public bool $update = false;

    public ?string $statePath = null;

    public ?string $blockId = null;

    public ?string $identifier = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema($this->getFormFields());
    }

    public function getFormFields(): array
    {
        return [];
    }

    public static function getAlignment(): Alignment
    {
        return static::$alignment ?? parent::getAlignment();
    }

    public static function getMaxWidth(): MaxWidth
    {
        return static::$maxWidth ?? parent::getMaxWidth();
    }

    public static function getSlideDirection(): SlideDirection
    {
        return static::$slideDirection ?? parent::getSlideDirection();
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->dispatch(
            event: 'handle-' . $this->identifier,
            statePath: $this->statePath,
            blockId: $this->blockId,
            context: $this->update ? 'update' : 'insert',
            values: $data
        );

        $this->unPounce();
    }

    public function render(): View
    {
        return view('scribble::components.form');
    }
}
