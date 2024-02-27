<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Wrappers\Group;
use Exception;

trait HasBubbleTools
{
    public function getBubbleTools(): array
    {
        if ($this->getProfile()) {
            $tools = app($this->getProfile())::bubbleTools() ?? [];
        } else {
            $tools = DefaultProfile::bubbleTools();
        }

        if (! isset($tools['link'])) {
            $tools['link'] = Link::make()->hidden();
        }

        return $tools;
    }

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getBubbleTools() as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupBlock) {
                    $tools[] = [
                        ...$groupBlock->toArray(),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tools[] = [
                    ...$tool->toArray(),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $tools;
    }
}
