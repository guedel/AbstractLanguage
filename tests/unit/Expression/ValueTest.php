<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Guedel\Tests\Unit\AL\Expression;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\Value;

/**
 * Description of ValueTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Value
 */
class ValueTest extends TestCase
{

  public function testConstruct()
  {
    $v = new Value(1234);
    $this->assertEquals(1234, $v->getValue());
  }

  public function testEvaluate()
  {
    $v = new Value(123);
    $visit = new \Guedel\Tests\Mock\AL\TestVisitor();
    $this->assertEquals(123, $v->evaluate($visit));
  }
}
