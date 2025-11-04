<?php


return [
    'html' => function ($tag) {

        $page = $tag->parent();
        $site = $page->site();
        $name = trim($tag->value);

        $sections = $page->ps_sections();

        if ($sections->isEmpty()) {
            return null;
        }
        $items = null;

        foreach ($sections->toStructure() as $section) {
            if ($name === (string)$section->name()) {
                $type = (string)$section->type();
                if ($type === 'bespoke') {
                    $snippetName = sprintf('bespoke/%s', $name);
                } else {
                    $snippetName = sprintf('tags/section-%s', $type);
                }
                ob_start();
                //  snippet($snippetName, ['section' => $section, 'sectionPage' => $page]);
                $out1 = ob_get_clean();
                return $out1;
            }
        }


        return null;
    }
];
