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

namespace Guedel\Tests\Functionnal\AL;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\BasicRuntimeVisitor;
use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;
use Guedel\Tests\Mock\AL\Programs\Runtime as Prog;
use Guedel\AL\Statement\StatementList;

/**
 * Description of BasicRuntimeVisitorTest
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicRuntimeVisitorTest extends TestCase
{
  private BasicRuntimeVisitor $visitor;
  
  public function setUp(): void
  {
    $this->visitor = new BasicRuntimeVisitor();
  }
  
  /**
   * @dataProvider programs
   * @coversNothing
   */
  public function testProgram(BaseTestProgram $p)
  {
    ob_start();
    $code = new StatementList($p->code());
    $this->visitor->run($code);
    $result = ob_get_flush();
    $this->assertEquals($p->expect(), $result);
  }

  public function programs()
  {
    return [
        'hello world' => [new Prog\HelloWorldProgram()],
    ];
  }

  
}
