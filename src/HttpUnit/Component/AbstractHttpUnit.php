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

  /**
   * Gets informations about HTTP transaction
   * 
   * @return string
   */
  public function getTransaction()
  {
    return $this->getCrawler()->getTransaction();
  }
}
