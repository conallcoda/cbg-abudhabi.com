<?php

$setModifiedAt = function (Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage) {
    return $newPage->update(['modified_at' => time()]);
};
$setCreatedAt = function (Kirby\Cms\Page $page) {
    return $page->update(['created_at' => time()]);
};

return [
    'hooks' => [
        'page.create:after' => function (Kirby\Cms\Page $page) use ($setCreatedAt) {
            $setCreatedAt($page);
            if ($page instanceof CFC\Model\HasAfterCreateHook) {
                $page->_afterCreate();
            }
        },
        'page.duplicate:after' => function (Kirby\Cms\Page $duplicatePage, Kirby\Cms\Page $originalPage) {
            if ($duplicatePage instanceof CFC\Model\HasAfterDuplicateHook) {
                $duplicatePage->_afterDuplicate();
            }
        },
        'page.update:after' => function (Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage) use ($setModifiedAt) {
            $newPage = $setModifiedAt($newPage, $oldPage);
            if ($newPage instanceof CFC\Model\HasAfterUpdateHook) {
                $newPage->_afterUpdate($newPage, $oldPage);
            }
        },
        'page.changeTitle:after' => $setModifiedAt,
        'page.changeStatus:after' => $setModifiedAt,
    ]
];
