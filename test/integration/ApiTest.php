<?php
namespace Barberry;
use Barberry\Test;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $applicationPath;

    protected function setUp() {
        $this->applicationPath = '/tmp/testBarberryEmbedded';
        @mkdir($this->applicationPath);
        $this->config = new Config($this->applicationPath);
        @mkdir($this->config->directoryCache, 0777, true);
        @mkdir($this->config->directoryStorage, 0777, true);
        @mkdir($this->config->directoryTemp, 0777, true);
    }

    protected function tearDown() {
        exec('rm -rf ' . $this->applicationPath);
    }

    public function testApiCanPut() {
        $filePath = Test\Data::gif1x1Path();
        $response = Api::put($this->config, $filePath);

        $this->assertInstanceOf('Barberry\\Response', $response);
        $this->assertEquals(201, $response->code);
    }

    public function testApiGetDataEqualPutted()
    {
        $filePath = Test\Data::gif1x1Path();
        $putted = json_decode(Api::put($this->config, $filePath)->body);

        $response = Api::get($this->config, $putted->id);
        $this->assertEquals(Test\Data::gif1x1(), $response->body);
    }

    public function testApiCanDeleteAfterPut()
    {
        $filePath = Test\Data::gif1x1Path();
        $putted = json_decode(Api::put($this->config, $filePath)->body);
        $response = Api::delete($this->config, $putted->id);
        $this->assertEquals(200, $response->code);
    }

    public function testApiCanGetOtherFormatAndSize() {
        $filePath = Test\Data::gif1x1Path();
        $putted = json_decode(Api::put($this->config, $filePath)->body);

        $response = Api::get($this->config, $putted->id . '_15x20.jpg');
        $this->assertEquals('jpg', $response->contentType->standardExtension());
    }

}
