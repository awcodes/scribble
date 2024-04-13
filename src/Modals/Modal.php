<?php

namespace Awcodes\Scribble\Modals;

use Awcodes\Scribble\Enums\Alignment;
use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Modals\Contracts\ModalComponent;
use Filament\Support\Enums\MaxWidth;
use Livewire\Component;

abstract class Modal extends Component implements ModalComponent
{
    public bool $forceClose = false;

    public int $skipModals = 0;

    public bool $destroySkipped = false;

    public static ?Alignment $alignment = Alignment::MiddleCenter;

    public static ?MaxWidth $maxWidth = MaxWidth::Medium;

    public static ?SlideDirection $slideDirection = SlideDirection::None;

    public function destroySkippedModals(): self
    {
        $this->destroySkipped = true;

        return $this;
    }

    public function skipPreviousModals($count = 1, $destroy = false): self
    {
        $this->skipPreviousModal($count, $destroy);

        return $this;
    }

    public function skipPreviousModal($count = 1, $destroy = false): self
    {
        $this->skipModals = $count;
        $this->destroySkipped = $destroy;

        return $this;
    }

    public function forceClose(): self
    {
        $this->forceClose = true;

        return $this;
    }

    public function closeScribbleModal(): void
    {
        $this->dispatch(
            event: 'closeScribbleModal',
            force: $this->forceClose,
            skipPreviousModals: $this->skipModals,
            destroySkipped: $this->destroySkipped
        );
    }

    public function closeModalWithEvents(array $events): void
    {
        $this->emitModalEvents($events);
        $this->closeScribbleModal();
    }

    public static function closeModalOnClickAway(): bool
    {
        return true;
    }

    public static function closeModalOnEscape(): bool
    {
        return true;
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return true;
    }

    public static function dispatchCloseEvent(): bool
    {
        return false;
    }

    public static function destroyOnClose(): bool
    {
        return false;
    }

    public static function getAlignment(): Alignment
    {
        return static::$alignment;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return static::$maxWidth;
    }

    public static function getSlideDirection(): SlideDirection
    {
        return static::$slideDirection;
    }

    public static function isSlideOver(): bool
    {
        return static::getSlideDirection() != SlideDirection::None;
    }

    private function emitModalEvents(array $events): void
    {
        foreach ($events as $component => $event) {
            if (is_array($event)) {
                [$event, $params] = $event;
            }

            if (is_numeric($component)) {
                $this->dispatch($event, ...$params ?? []);
            } else {
                $this->dispatch($event, ...$params ?? [])->to($component);
            }
        }
    }
}
