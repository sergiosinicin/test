<?php


use App\System\Library\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testJsonOutput()
    {
        ob_start();
        $response = new Response();
        $response->jsonOutput('test');

        $actualOutput = ob_get_clean();
        $this->assertSame($actualOutput, json_encode("test"));
    }

    public function testOutput()
    {
        ob_start();
        $response = new Response();
        $response->output('test');
        $actualOutput = ob_get_clean();
        $this->assertSame($actualOutput, "test");
    }
}
