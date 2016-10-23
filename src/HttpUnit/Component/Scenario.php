<?php

namespace HttpUnit\Component;

use HttpUnit\Component\Crawler;

class Scenario
{
  /** @var HttpUnit\Component\Crawler $crawler */
  protected $crawler;

  protected $name;
  protected $requests;
  protected $request;
  protected $responses;

  /**
   * @param Crawler $crawler
   * 
   * @param array $options Default options for the scenario
   */
  public function __construct(Crawler $crawler, $options = [])
  {
    $this->crawler = $crawler;
    
    foreach ($options as $key => $value)
    {
      if (property_exists($this, $key))
      {
        $this->$key = $value;
      }
    }
  }

  public function run()
  {
    # Multiple requests scenario
    if (count($this->requests))
    {
      foreach ($this->requests as $options)
      {
        $this->responses[] = $this->crawler->run( new Request($options) );
      }
    }
    # Single request scenario
    elseif (isset($this->request))
    {
      $this->responses[] = $this->crawler->run( new Request($this->request) );
    }
  }
}
