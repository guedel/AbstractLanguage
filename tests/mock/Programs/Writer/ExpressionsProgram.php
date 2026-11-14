<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
