<img
    src="{{ $src }}"
    alt="{{ $alt ?? '' }}"
    width="{{ $width }}"
    height="{{ $height }}"
    @if ($lazy)
        loading="lazy"
    @endif
    @if ($title)
        title="{{ $title }}"
    @endif
/>
