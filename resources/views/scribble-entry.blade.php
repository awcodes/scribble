@php
    $statePath = $getStatePath();

    $stylesheets = [
      Illuminate\Support\Js::from(\Filament\Support\Facades\FilamentAsset::getStyleHref('scribble-entry-styles', 'awcodes/scribble'))
    ];

    if ($getCustomStyles()) {
        $stylesheets[] = Illuminate\Support\Js::from($getCustomStyles());
    }

    $stylesheets = implode(',', $stylesheets);
@endphp
<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div
        wire:ignore
        x-data="{}"
        x-load-css="[{{ $stylesheets }}]"
    ></div>
    <div class="scribble-entry">
        {!! scribble($getState())->toHtml() !!}
    </div>
</x-dynamic-component>
