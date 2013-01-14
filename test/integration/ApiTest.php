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
        $this->assertNotNull($response);
    }

    public function testApiGetDataEqualPutted()
    {
        $filePath = Test\Data::gif1x1Path();
        $id = Api::put($this->config, $filePath);
        $this->assertNotNull($id);

        $data = Api::get($this->config, $id);
        $this->assertEquals(Test\Data::gif1x1(), $data);
    }

    public function testApiCanDeleteAfterPut()
    {
        $filePath = Test\Data::gif1x1Path();
        $id = Api::put($this->config, $filePath);
        $this->assertNotNull($id);

        $response = Api::delete($this->config, $id);
        $this->assertTrue($response);
    }

}
