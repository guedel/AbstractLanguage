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
use Guedel\AL\Expression\ExpressionList;
use Guedel\Tests\Mock\AL\EmptyExpression;

/**
 * Description of ExpressionListTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers ExpressionList
 */
class ExpressionListTest extends TestCase
{

  public function testEmpty()
  {
    $list = new ExpressionList();
    $this->assertCount(0, $list);
  }

  public function testCount()
  {
    $list = new ExpressionList(new EmptyExpression());
    $this->assertCount(1, $list);
  }

  public function testIterate()
  {
    $list = new ExpressionList(new EmptyExpression(), new EmptyExpression(), new EmptyExpression());
    $this->assertCount(3, $list);
    $this->assertContainsOnly(EmptyExpression::class, $list);
  }
}
