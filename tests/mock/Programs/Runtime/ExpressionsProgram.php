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
