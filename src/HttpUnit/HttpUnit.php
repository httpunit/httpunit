<?php

namespace HttpUnit;

use Exception;
use HttpUnit\Component\Crawler;
use HttpUnit\Component\Scenario;
use HttpUnit\Component\TestCase;

class HttpUnit
{
  /** @var HttpUnit\Component\Crawler $crawler */
  protected $crawler;

  /** @var HttpUnit\Component\Scenario $scenario */
  protected $scenario;

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
   * @param array $options Parameters
   */
  public function addScenario(array $options = [])
  {
    $this->scenario = new Scenario($this->crawler, $options);

    $this->scenario->run();

    $this->tester = new TestCase($this->crawler, $this->scenario);
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
   * @throws Exception
   */
  public function __call($name, $arguments)
  {
    switch(count($arguments))
    {
      case 0:
        return $this->tester->$name();
        break;
      case 1:
        return $this->tester->$name($arguments[0]);
        break;
      default:
        $message = sprintf('%s method does not support %d arguments'
          , __METHOD__
          , count($arguments)
        );
        throw new Exception($message);
    }
  }
}
