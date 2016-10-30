<?php

namespace HttpUnit\Component;

use HttpUnit\Http\Request;

class Scenario
{
  /** @var \HttpUnit\Component\Crawler */
  protected $crawler;

  /** @var string */
  protected $name;

  /** @var array */
  protected $request = [];

  /** @var array */
  protected $requests = [];

  /** @var array */
  protected $responses = [];

  /**
   * @param \HttpUnit\Component\Crawler $crawler
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
    elseif (count($this->request))
    {
      $this->responses[] = $this->crawler->run( new Request($this->request) );
    }
  }
}
