<?php

namespace Awcodes\Scribble\Actions\Concerns;

trait InteractsWithMedia
{
    public function getAcceptedFileTypes(): array
    {
        return config('scribble.media.accepted_file_types');
    }

    public function getDirectory(): string
    {
        return config('scribble.media.directory');
    }

    public function getDisk(): string
    {
        return config('scribble.media.disk');
    }

    public function getMaxFileSize(): int
    {
        return config('scribble.media.max_file_size');
    }

    public function getVisibility(): string
    {
        return config('scribble.media.visibility');
    }

    public function shouldPreserveFileNames(): bool
    {
        return config('scribble.media.preserve_file_names');
    }

    public function getImageResizeMode(): ?string
    {
        return config('scribble.media.image_resize_mode');
    }

    public function getImageCropAspectRatio(): ?string
    {
        return config('scribble.media.image_crop_aspect_ratio');
    }

    public function getImageResizeTargetWidth(): ?int
    {
        return config('scribble.media.image_resize_target_width');
    }

    public function getImageResizeTargetHeight(): ?int
    {
        return config('scribble.media.image_resize_target_height');
    }

    public function getUseRelativePaths(): bool
    {
        return config('scribble.media.use_relative_paths');
    }
}
