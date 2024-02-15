<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBubbleTools;
use Awcodes\Scribble\Concerns\HasCustomStyles;
use Awcodes\Scribble\Concerns\HasMergeTags;
use Awcodes\Scribble\Concerns\HasProfiles;
use Awcodes\Scribble\Concerns\HasSuggestionTools;
use Awcodes\Scribble\Concerns\HasToolbarTools;
use Awcodes\Scribble\Utils\Converter;
use Exception;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Component;

class Scribble extends Field
{
    use HasBubbleTools;
    use HasCustomStyles;
    use HasMergeTags;
    use HasPlaceholder;
    use HasProfiles;
    use HasSuggestionTools;
    use HasToolbarTools;

    protected string $view = 'scribble::scribble';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function (Scribble $component, Component $livewire): void {
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

    /**
     * @throws Exception
     */
    private function formatTool(ScribbleTool | string $tool): array
    {
        if (is_string($tool)) {
            $tool = new $tool();
        }

        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $tool->getIdentifier(),
            'extension' => $tool->getExtension(),
            'activeAttributes' => $tool->getActiveAttributes(),
            'icon' => $tool->getIcon(),
            'label' => ucfirst($tool->getLabel()),
            'description' => $tool->getDescription(),
            'type' => $tool->getType()->value,
            'commands' => $tool->getCommands(),
            'isHidden' => $tool->isHidden(),
        ];
    }
}
