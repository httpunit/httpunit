<?php

namespace HttpUnitTest\Asserts;

use PHPUnit_Framework_TestCase;
use HttpUnit\HttpUnit;

class ContentTypeTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->unit = new HttpUnit(['host' => '127.0.0.1']);
  }

  /**
   * Tests valid content types
   */
  public function testValidContentTypes()
  {
    $tests = [
      'text/html'
      , 'text/json'
      , 'application/pdf'
    ];

    foreach ($tests as $test)
    {
      $params = ['mime' => $test];

      $this->unit->addScenario([ 'request' => ['path' => '/asserts/content-types.php', 'params' => $params ] ]);

      $this->assertEquals(200, $this->unit->getResponse()->getStatusCode(), "Should be 200. Given '{$this->unit->getResponse()->getStatusCode()}'");
      $this->assertEquals(true, $this->unit->assertContentType($test), "Should be $test. Given '{$this->unit->getResponse()->getContentType()}'");
    }
  }
}
