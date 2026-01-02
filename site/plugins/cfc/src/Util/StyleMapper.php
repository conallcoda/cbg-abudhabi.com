<?php

namespace CFC\Util;

class StyleMapper
{

    public static function toClassNames($element, $defaults = [])
    {
        $classNames = [];


        $types = [
            'numeric' => [
                'padding_top' => 'pt-',
                'padding_right' => 'pr-',
                'padding_bottom' => 'pb-',
                'padding_left' => 'pl-',
                'margin_top' => 'mt-',
                'margin_right' => 'mr-',
                'margin_bottom' => 'mb-',
                'margin_left' => 'ml-',
            ],
            'color' => [
                'background_color' => 'bg-',
            ]
        ];


        foreach ($types as $method => $properties) {
            foreach ($properties as $property => $prefix) {
                if ($className = self::$method($element, $property, $prefix)) {
                    $classNames[] = $className;
                } elseif (!empty($defaults[$property])) {
                    $classNames[] = $defaults[$property];
                }
            }
        }


        if (!empty(array_intersect(['bg-black'], $classNames))) {
            $classNames[] = 'text-white';
            $classNames[] = 'dark-background';
        } else {
            $classNames[] = 'light-background';
        }

        // Add button theme context class based on background color
        $classNames[] = self::buttonThemeClass($classNames);


        return implode(' ', $classNames);
    }

    public static function numeric($element, $field, $prefix)
    {
        if ($element->$field()->isEmpty()) {
            return null;
        }
        return $prefix . (int)$element->$field()->value();
    }

    public static function color($element, $field, $prefix)
    {
        if ($element->$field()->isEmpty()) {
            return null;
        }

        $value = $element->$field()->value();
        $value = strtolower($value);
        $colorName = match ($value) {
            '#ffffff' => 'white',
            '#000000' => 'black',
            '#eeebec' => 'zinc',
            '#fcfbfa' => 'neutral',
            '#fdebdd' => 'sand',
            '#fd993c' => 'gold',
            default => null,
        };

        if ($colorName) {
            return $prefix . $colorName;
        }
    }

    public static function buttonThemeClass(array $classNames): string
    {
        // Determine button theme based on background color
        // neutral background → white buttons
        // zinc background → neutral buttons
        // black background → white buttons
        // default → sand buttons

        if (in_array('bg-neutral', $classNames)) {
            return 'btn-theme-zinc';
        }

        if (in_array('bg-zinc', $classNames)) {
            return 'btn-theme-white';
        }

        if (in_array('bg-black', $classNames)) {
            return 'btn-theme-white';
        }

        return 'btn-theme-sand';
    }
}
