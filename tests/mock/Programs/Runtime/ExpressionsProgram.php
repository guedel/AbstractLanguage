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

namespace Guedel\Tests\Mock\AL\Programs\Runtime;

use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;
use Guedel\AL\Statement\Statement;
use Guedel\AL\Declaration\Module;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\Expression;

/**
 * Description of ExpressionsProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class ExpressionsProgram implements BaseTestProgram
{
  //put your code here
  public function code(): Statement
  {
    return new Module(
        "expressions",
        new ProcedureCall("writeln", new BinaryExpression(Expression::OP_ADD, new Value(4), new Value(3))),
        new ProcedureCall("writeln", new BinaryExpression(Expression::OP_MULT, new Value(4), new Value(3))),
        new ProcedureCall("writeln", new BinaryExpression(Expression::OP_DIV, new Value(8), new Value(2))),
        new ProcedureCall("writeln", new BinaryExpression(Expression::OP_SUB, new Value(4), new Value(3))),
    );
  }

  public function expect(): string
  {
    return implode(PHP_EOL, [
        '7',
        '12',
        '4',
        '1',
    ]) . PHP_EOL;
  }
}
