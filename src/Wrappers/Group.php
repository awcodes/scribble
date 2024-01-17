<?php

namespace Awcodes\Scribble\Wrappers;

use Awcodes\Scribble\Concerns\HasBlocks;
use Filament\Forms\Components\Concerns\HasLabel;
use Filament\Support\Concerns\EvaluatesClosures;

class Group
{
    use EvaluatesClosures;
    use HasBlocks;
    use HasLabel;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label)
    {
        return app(static::class, ['label' => $label]);
    }
}
