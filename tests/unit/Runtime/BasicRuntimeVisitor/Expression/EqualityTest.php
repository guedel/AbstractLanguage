<?php

/*
 * The MIT License
 *
 * Copyright 2021 Guedel <guedel87@live.fr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\BasicRuntimeVisitor;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\Value;

/**
 * Description of EqualityTests
 *
 * @author Guedel <guedel87@live.fr>
 * @covers BinaryExpression::evaluate
 * @covers BasicRuntimeVisitor::evalBinaryExpression
 */
class EqualityTest extends TestCase
{
  private $visitor;
  
  public function setUp(): void
  {
    $this->visitor = new BasicRuntimeVisitor();
  }
  
  /**
   * @dataProvider equalityExpressions
   */
  public function testIsEqual($expect, BinaryExpression $exp)
  {
    $res = $exp->evaluate($this->visitor);
    $this->assertEquals($expect, $res);
  }
  
  /**
   * @dataProvider differentExpressions
   */
  public function testIsDifferent($expect, BinaryExpression $exp)
  {
    $res = $exp->evaluate($this->visitor);
    $this->assertEquals($expect, $res);
  }
  
  public function equalityExpressions()
  {
    return [
      1 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2))],  
      2 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(3))],  
      3 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2), new Value(2))],  
      4 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2), new Value(3))],  
      5 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(0), new Value(0), new Value(0))],  
      6 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(0), new Value(0), new Value(1))],  
    ];
  }
  
  public function differentExpressions()
  {
    return [
        1 => [0, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(2))],
        2 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3))],
        3 => [0, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(2), new Value(2))],
        4 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3), new Value(4))],
        5 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3), new Value(2))],
    ];
  }

}
