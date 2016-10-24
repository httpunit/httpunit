<?php

namespace HttpUnitTest\Component;

use PHPUnit_Framework_TestCase;
use HttpUnit\Component\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
  /**
   * Test default response values
   */
  public function testSetDefaults()
  {
    $response = new Response;

    $this->assertEquals(false, $response->getStatusCode(), 'Should be false');
    $this->assertEquals(false, $response->getContentType(), 'Should be false');
  }
}
