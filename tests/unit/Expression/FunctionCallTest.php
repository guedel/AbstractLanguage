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
namespace Guedel\Tests\Unit\Expression;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\FunctionCall;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of FunctionCallTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Expression\FunctionCall
 */
class FunctionCallTest extends TestCase
{
  private $function;
  private $visitor;

  public function setUp(): void
  {
    $this->function = new FunctionCall("cos");
    $this->visitor = new TestVisitor();
  }

  public function testConstruction()
  {
    $this->assertEquals('cos', $this->function->getName());
  }

  public function testEvaluate()
  {
    $this->assertEquals(0.66, $this->function->evaluate($this->visitor));
  }
}
