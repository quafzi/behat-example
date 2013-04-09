<?php

namespace Quafzi;

class Weather
{
    private $clouds;
    private $temperature;
    private $rain;

    public function parseInput($input)
    {
        if ($xml = @simplexml_load_string($input)) {
            $this->clouds      = (int) $xml->clouds;
            $this->temperature = (int) $xml->temperature;
            $this->rain        = (int) $xml->rain;
        } else {
            throw new \Exception('service currently not available');
        }
    }

    public function __call($method, $args)
    {
        if ('get' == substr($method, 0, 3) && isset($this->{lcfirst(substr($method, 3))})) {
            return $this->{lcfirst(substr($method, 3))};
        }
        throw new \BadMethodCallException(__class__ . ' has no method ' . $method);
    }

    public function setClouds($clouds)
    {
        $this->clouds = $clouds;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    public function setRain($rain)
    {
        $this->rain = $rain;
    }

    public function getCloudiness()
    {
        $cloudiness = 'bright';
        if (10 <= $this->clouds) {
            $cloudiness = 'partly cloudy';
        }
        if (30 <= $this->clouds) {
            $cloudiness = 'cloudy';
        }
        if (75 <= $this->clouds) {
            $cloudiness = 'clouded';
        }
        return $cloudiness;
    }

    public function getSummary()
    {
        if (80 < $this->clouds
            && $this->temperature < 20
            && 0 < $this->rain
        ) {
            return 'shit weather';
        }
        $summary = sprintf(
            'a %s %s day',
            (0 == $this->rain && $this->clouds < 50) ? 'beautiful' : 'ugly',
            20 < $this->temperature ? 'warm' : 'cold'
        );
        return $summary;
    }
}
