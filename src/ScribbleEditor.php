<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBubbleTools;
use Awcodes\Scribble\Concerns\HasCustomStyles;
use Awcodes\Scribble\Concerns\HasMergeTags;
use Awcodes\Scribble\Concerns\HasProfiles;
use Awcodes\Scribble\Concerns\HasSuggestionTools;
use Awcodes\Scribble\Concerns\HasToolbarTools;
use Awcodes\Scribble\Utils\Converter;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Component;

class ScribbleEditor extends Field
{
    use HasBubbleTools;
    use HasCustomStyles;
    use HasMergeTags;
    use HasPlaceholder;
    use HasProfiles;
    use HasSuggestionTools;
    use HasToolbarTools;

    protected string $view = 'scribble::scribble-editor';

    protected ?array $headingLevels = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function (ScribbleEditor $component, Component $livewire): void {
            $livewire->validateOnly($component->getStatePath());
        });

        $this->dehydrateStateUsing(function ($state) {
            if (! $state) {
                return null;
            }

            if (! is_array($state)) {
                $state = Converter::from($state)->toJson();
            }

            return $state;
        });
    }

    public function headingLevels(array $levels): static
    {
        $this->headingLevels = $levels;

        return $this;
    }

    public function getHeadingLevels(): ?array
    {
        return $this->headingLevels ?? config('scribble.globals.heading_levels');
    }
}
