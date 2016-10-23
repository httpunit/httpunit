<?php

namespace HttpUnitTest\Asserts;

use PHPUnit_Framework_TestCase;
use HttpUnit\HttpUnit;

class ResponseCodeTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->unit = new HttpUnit(['host' => '127.0.0.1']);
  }

  /**
   * Tests valid status codes
   */
  public function testValidCodes()
  {
    $tests = [
      100, 101
      , 200, 201, 202, 203, 204, 205, 206
      , 300, 301, 302, 303, 304, 305
      , 400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415
      , 500, 501, 502, 503, 504, 505
    ];

    foreach ($tests as $test)
    {
      $params = ['code' => $test];

      $this->unit->addScenario([ 'request' => ['path' => '/asserts/response-codes.php', 'params' => $params ] ]);

      $this->assertEquals(true, $this->unit->assertResponseCode($test), "Should be $test");
    }
   // $this->assertEquals('text/html', $this->unit->assertContentType(), 'Should be text/html');
  }

  /**
   * Tests a bad response code
   * Expects an internal error
   */
  public function testBadResponseCode()
  {
    $params = ['code' => 6000];
    $expected = 500;

    $this->unit->addScenario([ 'request' => ['path' => '/asserts/response-codes.php', 'params' => $params ] ]);

    $this->assertEquals($expected, $this->unit->assertResponseCode($expected), "Should be $expected");
  }
}
