<?php



return [
    'description' => 'Scaffold models',
    'args' => [],
    'command' => static function ($cli): void {

        $blueprintsDir = kirby()->root() . '/site/blueprints/pages';
        $modelsDir = kirby()->root() . '/site/models';

        foreach (scandir($blueprintsDir) as $filename) {
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'yml') {

                $baseName = pathinfo($filename, PATHINFO_FILENAME);


                $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $baseName))) . 'Page';

                $modelFilename = $baseName . '.php';
                $modelFilepath = $modelsDir . DIRECTORY_SEPARATOR . $modelFilename;


                if (!file_exists($modelFilepath)) {
                    $phpContent = "<?php\n\n";
                    $phpContent .= "class $className extends Page\n";
                    $phpContent .= "{\n";
                    $phpContent .= "}\n";
                    file_put_contents($modelFilepath, $phpContent);
                    $cli->out("Created: $modelFilepath");
                } else {
                    $cli->out("Already Exists: $modelFilepath");
                }
            }
        }
    }
];
