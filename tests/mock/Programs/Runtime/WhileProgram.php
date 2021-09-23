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
use Guedel\AL\Statement\WhileStmt;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\Expression;

/**
 * Description of WhileProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class WhileProgram implements BaseTestProgram
{
  public function code(): Statement
  {
    return new Module(
        "whilestmt",
        new VariableDecl('w'),
        new AssignStmt('w', new Value(0)),
        new WhileStmt(
            new BinaryExpression(Expression::OP_LTE, new Variable('w'), new Value(3)),
            new \Guedel\AL\Statement\StatementList(
                new ProcedureCall('writeln', new Variable('w')),
                new AssignStmt('w', new BinaryExpression(Expression::OP_ADD, new Variable('w'), new Value(1)))
            )
        )
    );
  }

  public function expect(): string
  {
    return join(PHP_EOL, [0,1,2,3]) . PHP_EOL;
  }
}
