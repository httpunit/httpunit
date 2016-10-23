<?php

namespace HttpUnit\Component;

class TestCase extends AbstractHttpUnit
{
  /** @var HttpUnit\Component\Crawler $crawler */
  protected $crawler;

  /** @var HttpUnit\Component\Scenario $scenario */
  protected $scenario;
  
  /**
   * @param HttpUnit\Component\Crawler $crawler
   * 
   * @param HttpUnit\Component\Scenario $scenario
   */
  public function __construct(Crawler $crawler, Scenario $scenario)
  {
    $this->crawler = $crawler;
    $this->scenario = $scenario;
  }

  /**
   * Performs an assert on response code
   * 
   * @param int $code
   * 
   * @return bool
   */
  public function assertResponseCode($code = null)
  {
    return $code === $this->getResponse()->getStatusCode();
  }
}
