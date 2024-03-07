@props([
    'align' => 'start',
])

<div
    {{ $attributes->class([
        'fi-modal-footer p-4 flex items-center gap-4',
        match($align) {
            'start' => 'justify-start',
            'center' => 'justify-center',
            'end' => 'justify-end',
        }
    ]) }}
>
    {{ $slot }}
</div>
