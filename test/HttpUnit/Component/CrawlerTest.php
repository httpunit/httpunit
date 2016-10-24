<?php

namespace HttpUnitTest\Component;

use PHPUnit_Framework_TestCase;
use HttpUnit\Component\Crawler;

class CrawlerTest extends PHPUnit_Framework_TestCase
{
  /**
   * Sets some default cookie values
   */
  public function testSetCookie()
  {
    $crawler = new Crawler([
      'verbose' => 'vv',
      'cookie'=> ['token'=>'value']
    ]);

    $this->assertArrayHasKey('token', $crawler->getCookie()->toArray());
    $this->assertEquals('value', $crawler->getCookie()->toArray()['token']);
  }
}
