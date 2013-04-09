<?php
namespace QuafziTest;

require_once 'src/Quafzi/Weather.php';
require_once 'src/Quafzi/Service.php';
use \Quafzi\Weather;
use \Mockery as m;

class WeatherTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchData()
    {
        // we need to mock our Service
        // using PHPUnit
        $service = $this->getMock('\Quafzi\Service', array('getData'));
        $service->expects($this->any())
            ->method('getData')
            ->will($this->returnValue($this->getInput(0, -10, 0)));

        /*
        // using Mockery
        $service = m::mock('\Quafzi\Service');
        $service->shouldReceive('getData')
            ->andReturn($this->getInput(0, -10, 0));
        */

        $weather = new Weather();
        $weather->fetchData($service);
        $this->assertEquals(0, $weather->getClouds());
        $this->assertEquals(-10, $weather->getTemperature());
        $this->assertEquals(0, $weather->getRain());
    }

    public function testMagicGetter()
    {
        $weather = new Weather();
        $this->assertNull($weather->getClouds());
        $this->assertNull($weather->getTemperature());
        $this->assertNull($weather->getRain());
        $this->setExpectedException('BadMethodCallException');
        $this->assertNull($weather->getFog());
    }

    public function testParseInputValid()
    {
        $weather = new Weather();
        $weather->parseInput($this->getInput(0, -10, 0));
        $this->assertEquals(0, $weather->getClouds());
        $this->assertEquals(-10, $weather->getTemperature());
        $this->assertEquals(0, $weather->getRain());
    }

    public function testGetCloudiness()
    {
        $map = array(
            0  => 'bright',
            20 => 'partly cloudy',
            50 => 'cloudy',
            90 => 'clouded'
        );
        $weather = new Weather();
        foreach ($map as $cloud=>$cloudiness) {
            $weather->setClouds($cloud);
            $this->assertEquals($cloudiness, $weather->getCloudiness());
        }
    }

    public function testGetSummary()
    {
        $weather = new Weather();
        $weather->setClouds(20);
        $weather->setTemperature(27);
        $weather->setRain(0);
        $this->assertEquals('a beautiful warm day', $weather->getSummary());

        $weather->setClouds(81);
        $weather->setTemperature(7);
        $weather->setRain(1);
        $this->assertEquals('shit weather', $weather->getSummary());
    }

    public function testParseInputInvalid()
    {
        $expectedError = 'service currently not available';
        $weather = new Weather();
        try {
            $weather->parseInput('<some>strange</parsing error>');
        } catch (\Exception $e) {
            if ($expectedError == $e->getMessage()) {
                return;
            }
        }
        $this->fail(sprintf(
            'Expected parsing exception with message "%s"',
            $expectedError
        ));

    }

    protected function getInput($clouds, $temperature, $rain)
    {
        $input = <<<XML
<weather>
    <clouds>%s</clouds>
    <rain>%s</rain>
    <temperature>%s</temperature>
</weather>
XML;
        return sprintf($input, $clouds, $rain, $temperature);
    }

    public function tearDown() {
        m::close();
    }
}
