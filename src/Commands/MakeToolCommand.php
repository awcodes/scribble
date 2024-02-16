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
                'command' => 'Command',
                'modal' => 'Modal',
                'block' => 'Block',
                'static-block' => 'Static Block',
            ],
            default: 'command',
            required: true,
        );

        $namespace = config('scribble.auto_discover.tools');
        $viewsPath = config('scribble.auto_discover.views');

        $className = (string) str($tool)->afterLast('\\');
        $toolLabel = (string) str($className)
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();
        $fullNamespace = str($namespace) . "\\{$className}";

        $view = (string) str($className)->kebab();

        $classPath = app_path((string)  str($className)
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

//        dd([
//            'tool' => $tool,
//            'type' => $type,
//            'class_name' => $className,
//            'tool_label' => $toolLabel,
//            'full_namespace' => $fullNamespace,
//            'view' => $view,
//            'class_path' => $classPath,
//            'view_path' => $viewPath,
//            'editor_view_path' => $editorViewPath,
//            'tool_view' => $toolView,
//            'tool_editor_view' => $toolEditorView,
//        ]);

        $files = [
            $classPath,
            $viewPath,
            $editorViewPath,
        ];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return static::INVALID;
        }

        $stub = 'tool-' . $type . '-class';

        $this->copyStubToApp($stub, $classPath, [
            'namespace' => $namespace,
            'class_name' => $className,
            'tool_label' => $toolLabel,
            'tool_view' => $toolView,
            'tool_editor_view' => $toolEditorView,
        ]);

        $this->copyStubToApp('tool-view', $viewPath);

        $this->copyStubToApp('tool-view', $editorViewPath);

        $this->components->info("Scribble tool [{$fullNamespace}] created successfully.");

        return self::SUCCESS;
    }
}
