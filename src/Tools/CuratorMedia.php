<?php

namespace Awcodes\Scribble\Tools;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Tiptap\Nodes\Image as ImageExtension;
use Illuminate\Support\Facades\Config;

class CuratorMedia extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-media')
            ->label('Media')
            ->type(ToolType::Event)
            ->commands([
                $this->makeCommand(command: 'setMedia'),
            ])
            ->converterExtensions(new ImageExtension())
            ->event(
                name: 'open-modal',
                data: [
                    'id' => 'curator-panel',
                    'settings' => [
                        'acceptedFileTypes' => Config::get('curator.accepted_file_types'),
                        'defaultSort' => 'desc',
                        'directory' => Config::get('curator.directory'),
                        'diskName' => Config::get('curator.disk'),
                        'imageCropAspectRatio' => Config::get('curator.image_crop_aspect_ratio'),
                        'imageResizeTargetWidth' => Config::get('curator.image_resize_target_width'),
                        'imageResizeTargetHeight' => Config::get('curator.image_resize_target_height'),
                        'imageResizeMode' => Config::get('curator.image_resize_mode'),
                        'isLimitedToDirectory' => false,
                        'isTenantAware' => Config::get('curator.is_tenant_aware'),
                        'tenantOwnershipRelationshipName' => Config::get('curator.tenant_ownership_relationship_name'),
                        'isMultiple' => true,
                        'maxItems' => null,
                        'maxSize' => Config::get('curator.max_size'),
                        'maxWidth' => Config::get('curator.max_width'),
                        'minSize' => Config::get('curator.min_size'),
                        'modalId' => null,
                        'pathGenerator' => Config::get('curator.path_generator'),
                        'rules' => [],
                        'selected' => [],
                        'shouldPreserveFilenames' => Config::get('curator.should_preserve_filenames'),
                        'statePath' => $this->getStatePath(),
                        'types' => Config::get('curator.accepted_file_types'),
                        'visibility' => Config::get('curator.visibility'),
                    ],
                ],
            );
    }
}
