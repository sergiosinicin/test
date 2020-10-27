<?php


use App\Formatter\ArrayFormatter;
use PHPUnit\Framework\TestCase;

class ArrayFormatterTest extends TestCase
{

    public function testObjectsToArray()
    {
        $expectedArray = [
            'qweqweqwe' => ['uuid' => 'qweqweqwe', 'firstname' => 'aaaaa', 'lastname' => 'bbbbbbbbb'],
            'asdasdasd' => ['uuid' => 'asdasdasd', 'firstname' => 'aaaaa', 'lastname' => 'cccccccccc'],
        ];

        $testArray = [
            1 => ['uuid' => 'qweqweqwe', 'firstname' => 'aaaaa', 'lastname' => 'bbbbbbbbb'],
            2 => ['uuid' => 'asdasdasd', 'firstname' => 'aaaaa', 'lastname' => 'cccccccccc'],
        ];

        $this->assertEquals(
            $expectedArray,
            ArrayFormatter::setUniqueKey($testArray, 'uuid')
        );

        $this->expectException("Exception");
        $this->expectExceptionMessage("Key aaaaa is not uniq");
        ArrayFormatter::setUniqueKey($testArray, 'firstname');
    }
}
