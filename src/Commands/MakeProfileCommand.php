<?php

namespace Awcodes\Scribble\Commands;

use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

class MakeProfileCommand extends Command
{
    use CanManipulateFiles;

    protected $signature = 'make:scribble-profile {name?} {--F|force}';

    protected $description = 'Scaffold a new Scribble Profile.';

    public function handle(): int
    {
        $profile = (string) str(
            $this->argument('name') ??
                text(
                    label: 'What is the profile name?',
                    placeholder: 'CustomProfile',
                    required: true,
                ),
        )
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        $namespace = config('scribble.generator.namespace') . '\\Profiles';

        $className = (string) str($profile)->afterLast('\\');

        $classPath = app_path((string) str($className)
            ->prepend('/')
            ->prepend($namespace)
            ->replace('\\', '/')
            ->replace('//', '/')
            ->replace('App', '')
            ->append('.php'));

        $files = [
            $classPath,
        ];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return static::INVALID;
        }

        $this->copyStubToApp('profile', $classPath, [
            'namespace' => $namespace,
            'class_name' => $className,
        ]);

        $fullNamespace = str($namespace) . "\\{$className}";

        $this->components->info("Scribble profile [{$fullNamespace}] created successfully.");

        return self::SUCCESS;
    }
}
