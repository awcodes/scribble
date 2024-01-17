<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-ignore
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('scribble', 'awcodes/scribble') }}"
        x-data="scribble(
            @js($getSchema()),
            $wire.{{ $applyStateBindingModifiers("entangle('{$getStatePath()}')", isOptimisticallyLive: false) }},
            @js($getStatePath()),
        )"
        @class([
            'scribble-wrapper relative z-0 rounded-md relative text-gray-950 bg-white shadow-sm ring-1 dark:bg-white/5 dark:text-white focus-within:ring focus-within:ring-primary-500 focus-within:z-10 prose dark:prose-invert',
            'ring-gray-950/10 dark:ring-white/20' => ! $errors->has($statePath),
            'ring-danger-600 dark:ring-danger-600' => $errors->has($statePath),
        ])
    ></div>
</x-dynamic-component>
