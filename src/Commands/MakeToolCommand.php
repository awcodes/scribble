<?php

namespace Awcodes\Scribble\Commands;

use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;

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
                'block' => 'Block',
                'command' => 'Command',
                'event' => 'Event',
                'modal' => 'Modal',
                'static' => 'Static Block',
            ],
            default: 'command',
            required: true,
        );

        $extensionType = select(
            label: 'What is the converter extension type?',
            options: [
                'none' => 'Not Applicable',
                'node' => 'Node',
                'mark' => 'Mark',
            ],
            default: 'node',
            required: true,
        );

        $namespace = config('scribble.generator.namespace') . '\\Tools';
        $viewsPath = config('scribble.generator.views');

        $className = (string) str($tool)->afterLast('\\');
        $fullNamespace = str($namespace) . "\\{$className}";
        $toolLabel = (string) str($className)
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();

        $view = (string) str($className)->kebab();

        $classPath = app_path((string) str($className)
            ->prepend('/')
            ->prepend($namespace)
            ->replace('\\', '/')
            ->replace('//', '/')
            ->replace('App', '')
            ->append('.php'));

        $viewPath = resource_path((string) str($view)
            ->prepend('/')
            ->prepend($viewsPath)
            ->prepend('/views/')
            ->replace('.', '/')
            ->replace('\\', '/')
            ->replace('//', '/')
            ->append('.blade.php'));

        $editorViewPath = resource_path((string) str($view)
            ->prepend('/')
            ->prepend($viewsPath)
            ->prepend('/views/')
            ->replace('.', '/')
            ->replace('\\', '/')
            ->replace('//', '/')
            ->append('-editor.blade.php'));

        $toolView = (string) str($viewsPath)
            ->append('.')
            ->replace('/', '.')
            ->append($view)
            ->trim('.');

        $toolEditorView = (string) str($viewsPath)
            ->append('.')
            ->replace('/', '.')
            ->append($view)
            ->append('-editor')
            ->trim('.');

        $modalPath = app_path((string) str('Modals')
            ->prepend('/')
            ->prepend($namespace)
            ->replace('\\', '/')
            ->replace('//', '/')
            ->replace('App', '')
            ->append('/' . $className . 'Modal')
            ->append('.php'));

        $extensionPath = app_path((string) str('Extensions')
            ->prepend('/')
            ->prepend($namespace)
            ->replace('\\', '/')
            ->replace('//', '/')
            ->replace('App', '')
            ->append('/' . $className . 'Extension')
            ->append('.php'));

        $files = [
            $classPath,
            $viewPath,
            $editorViewPath,
            $modalPath,
            $extensionPath,
        ];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return static::INVALID;
        }

        $this->copyStubToApp('tool', $classPath, [
            'namespace' => $namespace,
            'class_name' => $className,
            'label' => $toolLabel,
            'type' => match ($type) {
                'block' => 'ToolType::Block',
                'command' => 'ToolType::Command',
                'event' => 'ToolType::Event',
                'modal' => 'ToolType::Modal',
                'static-block' => 'ToolType::StaticBlock',
            },
            'editor_view' => $toolEditorView,
            'rendered_view' => $toolView,
        ]);

        if ($type === 'modal' || $type === 'block') {
            $this->copyStubToApp('modal', $modalPath, [
                'namespace' => $namespace . '\\Modals',
                'class_name' => $className,
                'label' => $toolLabel,
                'identifier' => str($toolLabel)->slug(),
            ]);
        }

        if ($extensionType !== 'none') {
            $this->copyStubToApp('extension', $extensionPath, [
                'namespace' => $namespace . '\\Extensions',
                'class_name' => $className,
                'extension_type' => ucfirst($extensionType),
                'extension_type_slug' => $extensionType,
                'identifier' => str($toolLabel)->slug(),
            ]);
        }

        $this->copyStubToApp('view', $viewPath);

        $this->copyStubToApp('view', $editorViewPath);

        $this->components->info("Scribble tool [{$fullNamespace}] created successfully.");

        return self::SUCCESS;
    }
}
