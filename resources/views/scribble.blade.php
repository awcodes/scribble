<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-data="{}"
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('scribble-styles', 'awcodes/scribble'))]"
    ></div>
    <div
        wire:ignore
        x-ignore
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('scribble-component', 'awcodes/scribble') }}"
        x-data="scribble(
            @js($getBubbleToolsSchema()),
            @js($getSuggestionToolsSchema()),
            @js($getToolbarToolsSchema()),
            $wire.{{ $applyStateBindingModifiers("entangle('{$getStatePath()}')", isOptimisticallyLive: false) }},
            @js($getStatePath()),
            @js($getPlaceholder()),
        )"
        x-on:toggle-fullscreen.window="toggleFullscreen($event)"
        x-on:keydown.esc.window="fullscreen = false"
        x-bind:class="{'fullscreen': fullscreen}"
        id="{{ 'scribble-wrapper-' . $getStatePath() }}"
        @class([
            'scribble-wrapper',
            'invalid' => $errors->has($statePath),
        ])
    ></div>
</x-dynamic-component>
