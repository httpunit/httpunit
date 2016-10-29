<?php

namespace HttpUnitTest\Component;

use PHPUnit_Framework_TestCase;
use HttpUnit\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
  /**
   * @expectedException Exception
   */
  public function testFailingGetter()
  {
    $request = new Request;

    $request->failingProperty;
  }
}
