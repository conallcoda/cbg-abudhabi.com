<?php



return [
    'description' => 'Scaffold templates',
    'args' => [],
    'command' => static function ($cli): void {

        $blueprintsDir = kirby()->root() . '/site/blueprints/pages';
        $modelsDir = kirby()->root() . '/site/templates';

        foreach (scandir($blueprintsDir) as $filename) {
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'yml') {

                $baseName = pathinfo($filename, PATHINFO_FILENAME);


                $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $baseName))) . 'Page';

                $modelFilename = $baseName . '.php';
                $modelFilepath = $modelsDir . DIRECTORY_SEPARATOR . $modelFilename;


                if (!file_exists($modelFilepath)) {
                    $phpContent = "";
                    file_put_contents($modelFilepath, $phpContent);
                    $cli->out("Created: $modelFilepath");
                } else {
                    $cli->out("Already Exists: $modelFilepath");
                }
            }
        }
    }
];
