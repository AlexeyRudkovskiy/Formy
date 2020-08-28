<?php


namespace Formy\Helpers;


class ArrayHelper
{

    public static function merge($source, &$destination): array
    {
        foreach ($source as $key => $value) {
            if (is_array($value)) {
                $value = ArrayHelper::merge($value, $destination[$key]);
            }

            $destination[$key] = $value;
        }

        return $destination;
    }

}
