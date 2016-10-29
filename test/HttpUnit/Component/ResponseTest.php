<?php

namespace HttpUnitTest\Component;

use PHPUnit_Framework_TestCase;
use HttpUnit\HttpUnit;
use HttpUnit\Http\Response;

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

  /**
   * Control that expected body has been received
   */
  public function testGetBody()
  {
    $unit = new HttpUnit(['host' => '127.0.0.1']);
    
    $html = $unit->addScenario(['request' => ['path' => '/content/helloworld.php']])
      ->getResponse()
      ->getBody();

    $this->assertEquals('Hello world!', $html, 'Should be "Hello world!"');
  }
}
