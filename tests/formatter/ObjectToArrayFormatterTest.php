<?php


use App\Formatter\ObjectToArrayFormatter;
use PHPUnit\Framework\TestCase;

class ObjectToArrayFormatterTest extends TestCase
{
    /** @var array */
    private $expectedArray;
    /** @var array */
    private $arrayOfObjects;

    protected function setUp(): void
    {
        parent::setUp();
        $faker = Faker\Factory::create();
        $this->expectedArray = [];

        for ($i = 0; $i <= 3; $i++) {
            $uuid = $faker->uuid;
            $this->expectedArray[$uuid] = [
                'uuid' => $uuid,
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'address' => $faker->address,
            ];
        }

        $this->arrayOfObjects = $this->prepareArray($this->expectedArray);
    }

    public function testObjectsToArray()
    {
        $this->assertEquals(
            $this->expectedArray,
            ObjectToArrayFormatter::objectsToArray($this->arrayOfObjects)
        );
    }

    public function testObjectsToIndexedArray()
    {
        $this->assertEquals(
            $this->expectedArray,
            ObjectToArrayFormatter::objectsToIndexedArray($this->arrayOfObjects, 'uuid')
        );
    }

    private function prepareArray(array $expectedArray)
    {
        $result = [];
        foreach ($expectedArray as $key => $item) {
            $result[$key] = json_decode(json_encode($item));
        }

        return $result;
    }

}
