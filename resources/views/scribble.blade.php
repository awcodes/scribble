@php
    $statePath = $getStatePath();

    $stylesheets = [
      Illuminate\Support\Js::from(\Filament\Support\Facades\FilamentAsset::getStyleHref('scribble-styles', 'awcodes/scribble'))
    ];

    if ($getCustomStyles()) {
        $stylesheets[] = Illuminate\Support\Js::from($getCustomStyles());
    }

    $stylesheets = implode(',', $stylesheets);

@endphp
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-data="{}"
        x-load-css="[{{ $stylesheets }}]"
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
            $wire.{{ $applyStateBindingModifiers("entangle('{$statePath}')", isOptimisticallyLive: false) }},
            @js($statePath),
            @js($getPlaceholder()),
        )"
        x-on:toggle-fullscreen.window="toggleFullscreen($event)"
        x-on:keydown.esc.window="fullscreen = false"
        x-bind:class="{'fullscreen': fullscreen}"
        id="{{ 'scribble-wrapper-' . $statePath }}"
        @class([
            'scribble-wrapper',
            'invalid' => $errors->has($statePath),
        ])
    ></div>
</x-dynamic-component>
