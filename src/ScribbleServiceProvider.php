<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Commands\MakeToolCommand;
use Awcodes\Scribble\Commands\ScribbleCommand;
use Awcodes\Scribble\Livewire\Renderer;
use Awcodes\Scribble\Testing\TestsScribble;
use BladeUI\Icons\Factory;
use Filament\Facades\Filament;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use ReflectionException;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ScribbleServiceProvider extends PackageServiceProvider
{
    public static string $name = 'scribble';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommands($this->getCommands());
    }

    public function packageRegistered(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/scribble.php', 'scribble');
        $this->mergeConfigFrom(__DIR__ . '/../config/scribble-icons.php', 'scribble-icons');

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('scribble-icons', []);

            $factory->add('scribble', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    /**
     * @throws ReflectionException
     */
    public function packageBooted(): void
    {
        require_once __DIR__ . '/render-helpers.php';

        foreach (Helpers::getToolClasses() as $block) {
            $block = new $block();
            Livewire::component($block->getIdentifier(), $block);
        }

        Livewire::component('scribble.renderer', Renderer::class);

        if (
            ! Helpers::isAuthRoute()
            && Filament::getCurrentPanel()
            && ! Filament::getCurrentPanel()->hasPlugin('scribblePlugin')
        ) {
            FilamentView::registerRenderHook(
                name: 'panels::body.end',
                hook: fn (): string => Blade::render('@livewire("scribble.renderer")')
            );

            FilamentView::registerRenderHook(
                name: 'panels::body.end',
                hook: fn (): string => Blade::render('@livewire("pounce")'),
            );
        }

        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/scribble/{$file->getFilename()}"),
                ], 'scribble-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsScribble());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'awcodes/scribble';
    }

    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('scribble-component', __DIR__ . '/../resources/dist/scribble.js'),
            Css::make('scribble-styles', __DIR__ . '/../resources/dist/scribble.css')->loadedOnRequest(),
        ];
    }

    protected function getCommands(): array
    {
        return [
            ScribbleCommand::class,
            MakeToolCommand::class,
        ];
    }

    protected function getScriptData(): array
    {
        return [];
    }
}
