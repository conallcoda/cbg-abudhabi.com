<?php

$pictures = include __DIR__ . '/pictures.php';

return [
    'description' => 'Nice command',
    'args' => [],
    'command' => static function ($cli) use ($pictures): void {
        kirby()->impersonate('kirby');
        $articles = site()->index(true)->filterBy('template', 'article');
        foreach ($articles as $page) {
            if ($page->ps_sections()->isNotEmpty()) {
                foreach ($page->ps_sections()->toStructure() as $section) {
                    $type = $section->type()->value();
                    $types[$type] = isset($types[$type]) ? $types[$type] + 1 : 1;
                    $typePages[$type] = isset($typePages[$type]) ? array_merge($typePages[$type], [$page->id()]) : [$page->id()];
                }
                $message = sprintf('%s', $page->id());
                $cli->out($message);
            }
        }
        $csv = [];
        foreach ($typePages['media_text'] as $url) {
            $url = str_replace('industry-insights/', '', $url);
            $local = sprintf('http://cfc.local/panel/pages/industry-insights+%s', $url);
            $live = sprintf('https://cfc-stmoritz.com/panel/pages/blog+%s', $url);

            $csv[] = sprintf('%s,%s', $local, $live);
        }

        file_put_contents('sections.csv', implode(PHP_EOL, $csv));
    }
];
