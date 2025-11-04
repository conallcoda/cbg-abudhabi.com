<?php

return function ($block) {
    switch ($block->list_type()->value()) {
        case 'selected':
            return $this->findPagesFromUuids($block->list_selected());
            break;
        case 'custom':
            return $block->list_custom()->toStructure();
            break;
        case 'list':
        default:
            if (!$block->list()->isEmpty()) {
                list($parentId, $listName) = explode('__', (string)$block->list());
                $parent = page('page://' . $parentId);
                foreach ($parent->lists()->toStructure() as $item) {
                    if ($listName === $item->name()->value()) {
                        return $this->findPagesFromUuids($item->items());
                    }
                }
                break;
            }
    }
};
