<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @if ($getCustomStyles())
        <div
            wire:ignore
            x-data="{}"
            x-load-css="[{{ \Illuminate\Support\Js::from($getCustomStyles()) }}]"
        ></div>
    @endif
    <div class="scribble-entry">
        {!! scribble($getState())->toHtml() !!}
    </div>
</x-dynamic-component>
