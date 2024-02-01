<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-ignore
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('scribble', 'awcodes/scribble') }}"
        x-data="scribble(
            @js($getToolsSchema()),
            $wire.{{ $applyStateBindingModifiers("entangle('{$getStatePath()}')", isOptimisticallyLive: false) }},
            @js($getStatePath()),
            @js($getPlaceholder()),
        )"
        x-on:toggle-fullscreen.window="toggleFullscreen($event)"
        x-on:keydown.esc.window="fullscreen = false"
        x-bind:class="{
            'fixed inset-0 z-50 fullscreen': fullscreen,
            'relative': !fullscreen,
        }"
        @class([
            'scribble-wrapper w-full rounded-md text-gray-950 bg-white shadow-sm ring-1 dark:bg-white/5 dark:text-white focus-within:ring focus-within:ring-primary-500 prose max-w-none dark:prose-invert prose-a:text-blue-500 dark:prose-a:text-blue-400',
            'ring-gray-950/10 dark:ring-white/20' => ! $errors->has($statePath),
            'ring-danger-600 dark:ring-danger-600' => $errors->has($statePath),
        ])
    ></div>
</x-dynamic-component>
