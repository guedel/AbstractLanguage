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

namespace Guedel\Tests\Mock\AL\Programs;

use Guedel\AL\Statement\StatementList;
use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Declaration\ParametersList;
use Guedel\AL\Declaration\Parameter;
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Datatype\TypeName;

/**
 * Description of FunctionDeclProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class FunctionDeclProgram implements BaseTestProgram
{
  public function attend(): string
  {
    return join(PHP_EOL, [
        "FUNCTION fact(IN n: int): int",
        "\tIF n <= 1 THEN",
        "\t\tRETURN 1",
        "\tEND IF",
        "\tRETURN n * fact(n - 1)",
        "END FUNCTION",
    ]) . PHP_EOL;
  }

  public function code(): \Guedel\AL\Statement\Statement
  {
    $int = new TypeName("int");
    return new StatementList(
        new FunctionDecl(
            "fact", 
            $int,
            new ParametersList(
                new Parameter("n", Parameter::INPUT, $int)
                ),
            new StatementList(
              new IfThenStmt(
                  new BinaryExpression(Expression::OP_LTE, new Variable("n"), new Value(1)),
                  new ReturnStmt(new Value(1)),
              ),
              new ReturnStmt(
                  new BinaryExpression(Expression::OP_MULT, 
                    new Variable("n"),
                    new FunctionCall("fact", new BinaryExpression(Expression::OP_SUB, new Variable("n"), new Value(1)))
                 )
              )
            )
        )
    );
  }
}
