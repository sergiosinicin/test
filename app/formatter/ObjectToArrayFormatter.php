<?php

namespace App\Formatter;

class ObjectToArrayFormatter
{
    /**
     * @param  array  $arrayOfObjects
     * @return mixed
     */
    public static function objectsToArray(array $arrayOfObjects)
    {
        return json_decode(json_encode($arrayOfObjects), true);
    }

    /**
     * @param  array  $arrayOfObjects
     * @param $key
     * @return array
     */
    public static function objectsToIndexedArray(array $arrayOfObjects, $key)
    {
        $array = self::objectsToArray($arrayOfObjects);
        $result = [];
        $defaultIndex = 0;
        foreach ($array as $item) {
            $index = $item[$key] ?? $defaultIndex;
            $result[$index] = $item;
        }

        return $result;
    }
}
