<div class="flex items-center gap-6 p-4">
    <div class="text-5xl">
        @php
            echo match(strtolower($name)) {
                'robin' => '🐤',
                'ivy' => '🥀',
                'joker' => '🤡',
                default => '🦇'
            }
        @endphp
    </div>
    <div class="not-prose">
        <p>Name: {{ $name }}</p>
        <p>Color: <span style="color: {{ strtolower($color) ?? 'text-danger-500' }};">{{ $color ?? 'Not Set' }}</span></p>
        <p>Side: {{ $side ?? 'Good' }}</p>
    </div>
</div>
