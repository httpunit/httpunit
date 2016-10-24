<?php

namespace HttpUnitTest\Component;

use PHPUnit_Framework_TestCase;
use HttpUnit\Component\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase
{
  /**
   * Sets some defalut values
   */
  public function testSetOptions()
  {
    $cookie = new Cookie(['token'=>'value']);

    $this->assertArrayHasKey('token', $cookie->toArray());
    $this->assertEquals('value', $cookie->toArray()['token']);
  }
}
