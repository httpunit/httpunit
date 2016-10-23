<?php

namespace HttpUnit\Component;

abstract class AbstractHttpUnit
{
  /**
   * Gets crawler instance
   * 
   * @return HttpUnit\Component\Crawler
   */
  public function getCrawler()
  {
    return $this->crawler;
  }

  /**
   * Gets last response instance
   * 
   * @return HttpUnit\Component\Response
   */
  public function getResponse()
  {
    return $this->getCrawler()->getResponse();
  }
}
