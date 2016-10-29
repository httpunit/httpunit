<?php

namespace HttpUnit;

use Exception;
use HttpUnit\Component\Crawler;
use HttpUnit\Component\Scenario;
use HttpUnit\Component\TestCase;

class HttpUnit
{
  /** @var HttpUnit\Component\Crawler */
  protected $crawler;

  /** @var HttpUnit\Component\Scenario */
  protected $scenario;

  /** @var HttpUnit\Component\TestCase */
  protected $tester;

  /**
   * @param array $options Default options for the crawler
   * 
   * @param array $scenario Default actions before starting tests
   */
  public function __construct($options = [], $scenario = [])
  {
    $this->crawler = new Crawler($options);

    if (count($scenario))
    {
      $this->addScenario($scenario);
    }
  }

  /**
   * @param array $options Scenario parameters
   * 
   * @return HttpUnit\HttpUnit
   */
  public function addScenario(array $options = [])
  {
    $this->scenario = new Scenario($this->crawler, $options);

    $this->scenario->run();

    $this->tester = new TestCase($this->crawler, $this->scenario);

    return $this;
  }

  /**
   * @param array $options Request parameters
   * 
   * @return HttpUnit\HttpUnit
   */
  public function addRequest(array $options = [])
  {
    return $this->addScenario(['request' => $options]);
  }

  /**
   * Overloads with $tester methods
   * 
   * @param string $name A method name
   *
   * @param array $arguments Some arguments for the method 
   *
   * @return mixed
   * 
   * @throws \Exception
   */
  public function __call($name, $arguments)
  {
    if (!($this->tester instanceof TestCase))
    {
      throw new Exception('A scenario must be played before assertions');
    }

    switch (count($arguments))
    {
      case 0:
        return $this->tester->$name();
      case 1:
        return $this->tester->$name($arguments[0]);
      default:
        throw new Exception(
          sprintf('%s method does not support %d arguments'
            , __METHOD__
            , count($arguments)
          )        
        );
        break;
    }
  }
}
