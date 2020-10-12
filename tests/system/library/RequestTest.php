<?php

use App\System\Library\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @var \Faker\Generator */
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

    public function testFiles()
    {
        $_FILES = [
            'image' => [
                'name' => 'image.jpg',
                'tmp' => $this->faker->image(),
                'type' => 'image/jpeg',
                'size' => 100,
                'error' => 0,
            ]
        ];

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $request = new Request();

        $files = $request->files('image');
        $this->assertEquals($files, $_FILES['image']);
    }

    public function testGet()
    {
        $_GET = [
            'test' => $this->faker->sentence,
        ];

        $request = new Request();
        $this->assertEquals($_GET['test'], $request->get('test'));
    }

    public function testPostAll()
    {
        $_POST = [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
        ];

        $request = new Request();
        $request->post($_POST['firstname'], $request->post('firstname'));
        $this->assertEquals($_POST, $request->postAll());
    }

    public function testPost()
    {
        $_POST = [
            'firstname' => $this->faker->firstName,
        ];

        $request = new Request();
        $this->assertEquals($_POST['firstname'], $request->post('firstname'));
    }
}
