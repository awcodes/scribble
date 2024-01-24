<?php

namespace Awcodes\Scribble\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TestForm extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                TextInput::make('name')->required()->columnSpanFull(),
                Select::make('type')
                    ->live()
                    ->options([
                    'foo' => 'Foo',
                    'bar' => 'Bar',
                ])->columnSpanFull(),
                TextInput::make('email')
                    ->visible(fn (Get $get) => $get('type') === 'foo')
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        dd($this->form->getState());
    }

    public function render(): View
    {
        return view('scribble::components.test-form');
    }
}
