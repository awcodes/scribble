<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Enums\ToolType;
use Closure;
use Exception;
use Filament\Support\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ScribbleTool extends Component
{
    protected string | null $icon = null;

    protected string | null $extension = null;

    protected bool | Closure | null $isHidden = null;

    protected string | Closure | null $description = null;

    protected string | null $identifier = null;

    protected string | null $editorView = null;

    protected string | null $renderedView = null;

    protected array | Closure | null $commands = null;

    protected array | string | Closure | null $active = null;

    protected string | null $statePath = null;

    protected string $name;

    protected string | Htmlable | Closure | null $label = null;

    protected bool $shouldTranslateLabel = false;

    protected ToolType | Closure | null $type = null;

    protected string | null $optionsModal = null;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string | null $name = null): static
    {
        if (! $name) {
            $name = str((new \ReflectionClass(static::class))->getShortName());
        }

        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function toArray(): array
    {
        return [
            'statePath' => $this->getStatePath(),
            'identifier' => $this->getIdentifier(),
            'extension' => $this->getExtension(),
            'active' => $this->getActive(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'type' => $this->getType()->value,
            'commands' => $this->getCommands(),
            'isHidden' => $this->isHidden(),
            'options' => $this->getOptionsModal(),
        ];
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string | Htmlable | null
    {
        $label = $this->evaluate($this->label) ?? (string) str($this->getName())
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();

        return $this->shouldTranslateLabel ? trans($label) : $label;
    }

    public function label(string | Htmlable | Closure | null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function translateLabel(bool $shouldTranslateLabel = true): static
    {
        $this->shouldTranslateLabel = $shouldTranslateLabel;

        return $this;
    }

    public function type(ToolType | Closure $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ToolType
    {
        return $this->evaluate($this->type) ?? ToolType::Command;
    }

    public function identifier(): static
    {
        $this->identifier = $this->name;
        return $this;
    }

    public function extension(string $extension): static
    {
        $this->extension = $extension;
        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function editorView(string $view): static
    {
        $this->editorView = $view;
        return $this;
    }

    public function renderedView(string $view): static
    {
        $this->renderedView = $view;
        return $this;
    }

    public function commands(array | Closure $commands): static
    {
        $this->commands = $commands;
        return $this;
    }

    public function active(string $extension, array | string | null $attrs = null): static
    {
        $this->active = [
            'extension' => $extension,
            'attrs' => $attrs ?? [],
        ];

        return $this;
    }

    public function hidden(bool | Closure $condition = true): static
    {
        $this->isHidden = $condition;
        return $this;
    }

    public function description(string | Closure $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function optionsModal(string $component): static
    {
        $this->optionsModal = $component;

        return $this;
    }

    public function getStatePath(): ?string
    {
        return $this->statePath ?? null;
    }

    public function getIdentifier(): string
    {
        return $this->evaluate($this->identifier) ?? str($this->name)->replace('_', '-')->kebab();
    }

    public function getExtension(): string
    {
        return $this->evaluate($this->extension) ?? str($this->name)->replace('_', '-')->kebab();
    }

    public function getIcon(): string
    {
        $icon = $this->evaluate($this->icon) ?? 'heroicon-o-cube';
        $html = svg($icon)->toHtml();

        if (! str($html)->contains('title')) {
            $html = str($html)->replace('</svg', '<title>' . $this->getLabel() . '</title></svg');
        }

        return $html;
    }

    /**
     * @throws Exception
     */
    public function getEditorView(array $data = []): View
    {
        if (! $this->evaluate($this->editorView)) {
            return $this->getRenderedView($data);
        }

        return view($this->evaluate($this->editorView), $data);
    }

    /**
     * @throws Exception
     */
    public function getRenderedView(array $data = []): View
    {
        if (! view()->exists($this->evaluate($this->renderedView))) {
            throw new Exception('Rendered view not found: ' . $this->evaluate($this->renderedView));
        }

        return view($this->evaluate($this->renderedView), $data);
    }

    public function getCommands(): array
    {
        return $this->evaluate($this->commands) ?? [];
    }

    public function getActive(): array
    {
        return filled($this->active) ? $this->evaluate($this->active) : ['extension' => $this->getExtension(), 'attrs' => []];
    }

    public function isHidden(): bool
    {
        return $this->evaluate($this->isHidden) ?? false;
    }

    public function getDescription(): ?string
    {
        return $this->evaluate($this->description) ?? null;
    }

    public function getOptionsModal(): ?string
    {
        return $this->optionsModal;
    }

    public function makeCommand(string $command, string | array | null $arguments = null): array
    {
        return Helpers::makeCommand($command, $arguments);
    }
}
