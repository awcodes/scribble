<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Commands\ScribbleCommand;
use Awcodes\Scribble\Livewire\Renderer;
use Awcodes\Scribble\Testing\TestsScribble;
use BladeUI\Icons\Factory;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ScribbleServiceProvider extends PackageServiceProvider
{
    public static string $name = 'scribble';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
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

    public function packageBooted(): void
    {
        foreach (Helpers::getToolClasses() as $block) {
            $block = new $block();

            Livewire::component($block->getIdentifier(), $block);
        }

        Livewire::component('scribble.renderer', Renderer::class);

        FilamentView::registerRenderHook(
            'panels::body.end',
            fn (): string => Blade::render('@livewire(\'scribble.renderer\')')
        );

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

        require_once __DIR__ . '/render-helpers.php';
    }

    protected function getAssetPackageName(): ?string
    {
        return 'awcodes/scribble';
    }

    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('scribble-component', __DIR__ . '/../resources/dist/scribble.js'),
            Css::make('scribble-styles', __DIR__ . '/../resources/dist/scribble.css')
                ->loadedOnRequest(),
            //            Js::make('scribble-scripts', __DIR__ . '/../resources/dist/scribble.js'),
        ];
    }

    protected function getCommands(): array
    {
        return [
            ScribbleCommand::class,
        ];
    }

    protected function getScriptData(): array
    {
        return [];
    }
}
