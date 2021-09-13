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

namespace Guedel\Tests\Mock\AL\Programs\Writer;

use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;

use Guedel\AL\Statement\{StatementList, ReturnStmt};
use Guedel\AL\Expression\{
  Expression,
  UnaryExpression,
  BinaryExpression,
  Value,
  Variable
};

/**
 *Test of expressions
 *
 * @author Guedel <guedel87@live.fr>
 */
class ExpressionsProgram implements BaseTestProgram
{
  public function expect(): string
  {
    return join(PHP_EOL, [
        "RETURN a, -a, NOT a",
        "RETURN a + b, a - b, a * b, a / b, a != b"
    ]) . PHP_EOL;
  }

  public function code(): \Guedel\AL\Statement\Statement
  {
    return new StatementList(
        new ReturnStmt(
            new UnaryExpression(Expression::OP_ADD, new Variable("a")),
            new UnaryExpression(Expression::OP_SUB, new Variable("a")),
            new UnaryExpression(Expression::OP_NOT, new Variable("a"))
        ),
        new ReturnStmt(
            new BinaryExpression(Expression::OP_ADD, new Variable("a"), new Variable("b")),
            new BinaryExpression(Expression::OP_SUB, new Variable("a"), new Variable("b")),
            new BinaryExpression(Expression::OP_MULT, new Variable("a"), new Variable("b")),
            new BinaryExpression(Expression::OP_DIV, new Variable("a"), new Variable("b")),
            new BinaryExpression(Expression::OP_DIFF, new Variable("a"), new Variable("b"))
        )
    );
  }
}
