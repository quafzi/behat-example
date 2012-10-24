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
    public function xmlInput($arg1)
    {
        $this->input = $arg1;
    }

    /**
     * @When /^I run my application$/
     */
    public function iRunMyApplication()
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
    public function iShouldGetAnExceptionWithMessage($arg1)
    {
        assertEquals($arg1, $this->exceptionMessage);
    }

    /**
     * @Then /^I should get no exception$/
     */
    public function iShouldGetNoException()
    {
        assertNull($this->exceptionMessage);
    }

    /**
     * @Given /^I should get a weather class instance$/
     */
    public function iShouldGetAWeatherClassInstance()
    {
        assertTrue(is_object($this->instance), 'expected object');
        assertInstanceOf('Quafzi\Weather', $this->instance);
    }

    /**
     * @Given /^value (\d+) for clouds$/
     */
    public function valueForClouds($arg1)
    {
        $this->instance->setClouds($arg1);
    }

    /**
     * @When /^I call cloudiness$/
     */
    public function iCallCloudiness()
    {
        $this->cloudiness = $this->instance->getCloudiness();
    }

    /**
     * @Then /^I should get cloudiness (.+)$/
     */
    public function iShouldGetCloudiness($arg1)
    {
        assertEquals($arg1, $this->cloudiness);
    }

    /**
     * @Given /^value (\d+) for temperature$/
     */
    public function valueForTemperature($arg1)
    {
        $this->instance->setTemperature($arg1);
    }

    /**
     * @Given /^value (\d+) for rain$/
     */
    public function valueForRain($arg1)
    {
        $this->instance->setRain($arg1);
    }

    /**
     * @When /^I call summary$/
     */
    public function iCallSummary()
    {
        $this->summary = $this->instance->getSummary();
    }

    /**
     * @Then /^I should get summary "([^"]*)"$/
     */
    public function iShouldGetSummary($arg1)
    {
        assertEquals($arg1, $this->summary, 'got "' . $this->summary . '" instead');
    }

    /**
     * @Given /^value <cloud> for clouds$/
     */
    public function valueCloudForClouds()
    {
        throw new PendingException();
    }
}
