<?php

namespace HttpUnitTest;

use PHPUnit_Framework_TestCase;
use HttpUnit\HttpUnit;

class HttpUnitTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->unit = new HttpUnit(['host' => '127.0.0.1']);
  }

  /**
   * Tests that server is responding
   */
  public function testHome()
  {
    $this->unit->addScenario(['request' => ['path' => '/index.php']]);

    $this->assertEquals(200, $this->unit->getResponse()->getStatusCode(), 'Should be 200');
  }

  /**
   * @expectedException Exception
   */
  public function testCallMethodWithTooManyArguments()
  {
    $this->unit->assertContentType(1, 2, 3);
  }

  /**
   * Tests an unit with a preloaded scenario
   */
  public function testPreloadingScenario()
  {
    $unit = new HttpUnit(['host' => '127.0.0.1'], ['request' => ['path' => '/index.php']]);

    $this->assertEquals(200, $unit->getResponse()->getStatusCode(), 'Should be 200');
  }

  /**
   * Tests an unit with a preloaded multi-requests scenario
   */
  public function testPreloadingMultiRequestScenario()
  {
    $scenario = [ 'name' => 'multiRequestScenario', 'requests' => [
        ['path' => '/index.php'],
        ['path' => '/index.php'],
        ['path' => '/index.php']
      ]
    ];

    $unit = new HttpUnit(['host' => '127.0.0.1'], $scenario);

    $this->assertEquals(200, $unit->getResponse()->getStatusCode(), 'Should be 200');
  }
}
