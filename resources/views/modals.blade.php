<div>
    @php
        use Awcodes\Scribble\Enums\Alignment;
        use Filament\Support\Enums\MaxWidth;
    @endphp

    <div
        x-data="scribbleModal()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="closeModalOnEscape()"
        x-show="show"
        class="scribble-modal-container fixed flex inset-0 z-40 overflow-y-auto overflow-x-hidden transition"
        style="display: none;"
        x-bind:class="{
            'items-start': modalAlignment?.includes('top'),
            'items-center': modalAlignment?.includes('middle'),
            'items-end': modalAlignment?.includes('bottom'),
            'justify-start': modalAlignment?.includes('start') || (isSlideOver && slideDirection === 'left'),
            'justify-center': modalAlignment?.includes('center'),
            'justify-end': modalAlignment?.includes('end') || (isSlideOver && slideDirection === 'right'),
            'p-6': ! (isSlideOver || (modalWidth === 'screen')),
        }"
    >
        <div
            x-show="show && showActiveComponent"
            x-on:click="closeModalOnClickAway()"
            class="absolute inset-0 z-0 transition inset-0 bg-gray-950/50 dark:bg-gray-950/75"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div
            x-show="show && showActiveComponent"
            x-trap.noscroll.inert="show && showActiveComponent"
            aria-modal="true"
            x-transition:enter-start="enter-start"
            x-transition:enter-end="enter-end"
            x-transition:leave-start="leave-start"
            x-transition:leave-end="leave-end"
            class="scribble-modal w-full flex flex-col bg-white ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden shadow-xl transition pointer-events-auto"
            style="will-change: auto;"
            x-bind:class="{
                'max-w-xs': modalWidth === 'xs',
                'max-w-sm': modalWidth === 'sm',
                'max-w-md': modalWidth === 'md',
                'max-w-lg': modalWidth === 'lg',
                'max-w-xl': modalWidth === 'xl',
                'max-w-2xl': modalWidth === '2xl',
                'max-w-3xl': modalWidth === '3xl',
                'max-w-4xl': modalWidth === '4xl',
                'max-w-5xl': modalWidth === '5xl',
                'max-w-6xl': modalWidth === '6xl',
                'max-w-7xl': modalWidth === '7xl',
                'max-w-full': modalWidth === 'full',
                'max-w-min': modalWidth === 'min',
                'max-w-max': modalWidth === 'max',
                'max-w-fit': modalWidth === 'fit',
                'max-w-prose': modalWidth === 'prose',
                'max-w-screen-sm': modalWidth === 'screen-sm',
                'max-w-screen-md': modalWidth === 'screen-md',
                'max-w-screen-lg': modalWidth === 'screen-lg',
                'max-w-screen-xl': modalWidth === 'screen-xl',
                'max-w-screen-2xl': modalWidth === 'screen-2xl',
                'fixed inset-0 fade': modalWidth === 'screen',
                'overflow-y-auto': isSlideOver,
                'relative': ! isSlideOver,
                'right-0 fixed slide-from-right': slideDirection === 'right',
                'left-0 fixed slide-from-left': slideDirection === 'left',
                'top-0 fixed slide-from-top': slideDirection === 'top',
                'bottom-0 fixed slide-from-bottom': slideDirection === 'bottom',
                'h-dvh': isSlideOver || (modalWidth === 'screen'),
                'pop rounded-xl': ! (isSlideOver || (modalWidth === 'screen')),
            }"
        >
            @forelse($components as $id => $component)
                <div x-show.immediate="activeComponent === '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}" class="h-full">
                    @livewire($component['name'], $component['arguments'], key($id))
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
