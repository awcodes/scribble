<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasCustomStyles;
use Filament\Infolists\Components\Entry;

class ScribbleEntry extends Entry
{
    use HasCustomStyles;

    protected string $view = 'scribble::scribble-entry';
}
