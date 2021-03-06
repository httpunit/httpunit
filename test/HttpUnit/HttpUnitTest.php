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
   * Tests a POST scenario
   */
  public function testPostScenario()
  {
    $this->unit->addScenario(['request' => [
        'path' => '/method/post.php'
        , 'method' => 'POST'
        , 'params' => ['user' => 'bob']
      ]
    ]);

    $this->assertEquals(200, $this->unit->getResponse()->getStatusCode(), 'Should be 200');
  }

  /**
   * Tests addRequest shortcut
   */
  public function testAddRequestShortcut()
  {
    $unit = new HttpUnit(['host' => '127.0.0.1']);

    $unit->addRequest(['path' => '/index.php']);

    $this->assertEquals(
      200, 
      $unit->getResponse()->getStatusCode(),
      'Should be 200'
    );
  }

  /**
   * Tests user-agent customization
   */
  public function testUACustomization()
  {
    $unit = new HttpUnit([
      CURLOPT_USERAGENT => 'Custom User Agent',
      'host' => '127.0.0.1'
    ]);

    $unit->addRequest(['path' => '/content/useragent.php']);

    $this->assertEquals(
      'Custom User Agent',
      $unit->getResponse()->getBody(),
      'Should be "Custom User Agent"'
    );
  }

  /**
   * Tests header customization
   */
  public function testHeaderCustomization()
  {
    $unit = new HttpUnit(['host' => '127.0.0.1']);

    $unit->addRequest([
      'path' => '/content/customheaders.php',
      'headers' => ['X-Requested-With' => 'XMLHttpRequest']
    ]);

    $this->assertEquals(
      'XMLHttpRequest',
      $unit->getResponse()->getBody(),
      'Should be "XMLHttpRequest"'
    );
  }

  /**
   * Tests verbose mode
   */
  public function testVerboseMode()
  {   
    $unit = new HttpUnit(['verbose' => 'vv', 'host' => '127.0.0.1']);

    $unit->addRequest(['path' => '/index.php']);

    $this->assertRegExp('#> GET /index.php HTTP/1.1#', $unit->getTransaction(), 'Should contain "GET /index.php HTTP/1.1"');
    $this->assertRegExp('#\* Closing connection \#0#', $unit->getTransaction(), 'Should contain "* Closing connection #0"');
  }

  /**
   * @expectedException Exception
   */
  public function testCallMethodWithTooManyArguments()
  {
    $this->unit->addScenario(['request' => ['path' => '/index.php']]);

    $this->unit->assertContentType(1, 2, 3);
  }

  /**
   * @expectedException Exception
   */
  public function testAssertBeforeScenario()
  {
    $unit = new HttpUnit();

    $unit->assertContentType('text/html');
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
