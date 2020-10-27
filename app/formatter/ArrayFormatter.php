<?php


namespace App\Formatter;

use Exception;

class ArrayFormatter
{
    /**
     * @param  array  $array
     * @param  string  $uniqKey
     * @return array
     * @throws Exception
     */
    public static function setUniqueKey(array $array, string $uniqKey)
    {
        $result = [];
        foreach ($array as $defaultKey => $item) {
            $index = array_key_exists($uniqKey, $item) ? $item[$uniqKey] : $defaultKey;
            if (array_key_exists($index, $result)) {
                throw new Exception("Key $index is not unique");
            }
            $result[$index] = $item;
        }

        return $result;
    }
}
