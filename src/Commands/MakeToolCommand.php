<?php

namespace Awcodes\Scribble\Commands;

use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class MakeToolCommand extends Command
{
    use CanManipulateFiles;

    protected $signature = 'make:scribble-tool {name?} {--F|force}';

    protected $description = 'Scaffold a new Scribble tool.';

    public function handle(): int
    {
        $tool = (string) str(
            $this->argument('name') ??
                text(
                    label: 'What is the tool name?',
                    placeholder: 'CustomTool',
                    required: true,
                ),
        )
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        $type = select(
            label: 'What is the tool type?',
            options: [
                'command' => 'Command',
                'modal' => 'Modal',
                'block' => 'Block',
                'static-block' => 'Static Block',
            ],
            default: 'command',
            required: true,
        );

        $toolClass = (string) str($tool)->afterLast('\\');
        $toolNamespace = str($tool)->contains('\\')
            ? (string) str($tool)->beforeLast('\\')
            : '';

        $namespace = config('scribble.auto_discover.tools');

        $path = app_path('TiptapBlocks/');

        $preview = str($tool)
            ->prepend(
                (string) str("{$namespace}\\Previews\\")
                    ->replaceFirst('App\\', '')
            )
            ->replace('\\', '/')
            ->explode('/')
            ->map(fn ($segment) => Str::lower(Str::kebab($segment)))
            ->implode('.');

        $rendered = str($block)
            ->prepend(
                (string) str("{$namespace}\\Rendered\\")
                    ->replaceFirst('App\\', '')
            )
            ->replace('\\', '/')
            ->explode('/')
            ->map(fn ($segment) => Str::lower(Str::kebab($segment)))
            ->implode('.');

        $path = (string) str($block)
            ->prepend('/')
            ->prepend($path ?? '')
            ->replace('\\', '/')
            ->replace('//', '/')
            ->append('.php');

        $previewPath = resource_path(
            (string) str($preview)
                ->replace('.', '/')
                ->prepend('views/')
                ->append('.blade.php'),
        );

        $renderedViewPath = resource_path(
            (string) str($rendered)
                ->replace('.', '/')
                ->prepend('views/')
                ->append('.blade.php'),
        );

        $files = [
            $path,
            $previewPath,
            $renderedViewPath,
        ];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return static::INVALID;
        }

        $stub = 'tool-' . $type . '-class.stub';

        $this->copyStubToApp($stub, $path, [
            'namespace' => str($namespace) . ($blockNamespace !== '' ? "\\{$blockNamespace}" : ""),
            'class_name' => $blockClass,
            'tool_label' => $preview,
            'tool_view' => $rendered,
            'tool_rendered_view' => $rendered,
        ]);

        $this->copyStubToApp('tool-view', $previewPath);

        $this->copyStubToApp('tool-view', $renderedViewPath);

        $this->components->info("Scribble tool [{$path}] created successfully.");

        return self::SUCCESS;
    }
}
