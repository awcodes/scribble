<?php

namespace Awcodes\Scribble\Wrappers;

use Awcodes\Scribble\Concerns\HasTools;
use Filament\Forms\Components\Concerns\HasLabel;
use Filament\Support\Concerns\EvaluatesClosures;

class Group
{
    use EvaluatesClosures;
    use HasLabel;
    use HasTools;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label)
    {
        return app(static::class, ['label' => $label]);
    }
}
