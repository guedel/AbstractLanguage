<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
