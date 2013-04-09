<?php
namespace QuafziTest;

require_once 'src/Quafzi/Weather.php';
use \Quafzi\Weather;

class WeatherTest extends \PHPUnit_Framework_TestCase
{
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
}
