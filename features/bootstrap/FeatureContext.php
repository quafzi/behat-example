<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once 'src/Quafzi/Weather.php';
use Quafzi\Weather;

//
// Require 3rd-party libraries here:
//
   require_once 'PHPUnit/Autoload.php';
   require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    protected $input;
    protected $instance;
    protected $exceptionMessage;
    protected $cloudiness;
    protected $summary;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->instance = new Weather();
    }

    /**
     * @Given /^xml input "([^"]*)"$/
     */
    public function xmlInput($input)
    {
        $this->input = $input;
    }

    /**
     * @When /^I run my application$/
     */
    public function parseInput()
    {
        $this->exceptionMessage = null;
        try {
            $this->instance->parseInput($this->input);
        } catch (\Exception $e) {
            $this->exceptionMessage = $e->getMessage();
        }
    }

    /**
     * @Then /^I should get an exception with message "([^"]*)"$/
     */
    public function expectException($message)
    {
        assertEquals($message, $this->exceptionMessage);
    }

    /**
     * @Then /^I should get no error$/
     */
    public function expectNoException()
    {
        assertNull($this->exceptionMessage);
    }

    /**
     * @Given /^I should be able to get weather information$/
     */
    public function expectWeatherClassInstance()
    {
        assertTrue(is_object($this->instance), 'expected object');
        assertInstanceOf('Quafzi\Weather', $this->instance);
    }

    /**
     * @Given /^value (\d+) for clouds$/
     */
    public function setClouds($clouds)
    {
        $this->instance->setClouds($clouds);
    }

    /**
     * @When /^I call cloudiness$/
     */
    public function getCloudiness()
    {
        $this->cloudiness = $this->instance->getCloudiness();
    }

    /**
     * @Then /^I should get cloudiness (.+)$/
     */
    public function expectCloudiness($cloudiness)
    {
        assertEquals($cloudiness, $this->cloudiness);
    }

    /**
     * @Given /^value (\d+) for temperature$/
     */
    public function setTemperature($temperature)
    {
        $this->instance->setTemperature($temperature);
    }

    /**
     * @Given /^value (\d+) for rain$/
     */
    public function setRain($rain)
    {
        $this->instance->setRain($rain);
    }

    /**
     * @When /^I call summary$/
     */
    public function getSummary()
    {
        $this->summary = $this->instance->getSummary();
    }

    /**
     * @Then /^I should get summary "([^"]*)"$/
     */
    public function expectSummary($summary)
    {
        assertEquals($summary, $this->summary, 'got "' . $this->summary . '" instead');
    }
}
