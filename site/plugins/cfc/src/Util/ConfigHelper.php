<?php

namespace CFC\Util;

class ConfigHelper
{

    public static function getFunctions($path)
    {

        $functions = [];
        $path = $path . '/*.php';
        foreach (glob($path) as $subPath) {
            $name = basename($subPath, '.php');
            $fn = require($subPath);
            $functions[$name] = $fn;
        }


        return $functions;
    }

    public static function getBlueprints()
    {
        $types = ['blocks', 'field', 'files'];

        $items = [];
        foreach ($types as $type) {
            $paths = [__DIR__ . '/../blueprints/' . $type . '/*.yml'];
            foreach ($paths as $path) {
                foreach (glob($path) as $subPath) {
                    $name = sprintf('%s/%s', $type, basename($subPath, '.yml'));
                    $items[$name] = $subPath;
                }
            }
        }

        return $items;
    }
}
