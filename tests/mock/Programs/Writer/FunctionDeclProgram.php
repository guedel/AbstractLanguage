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
    public function expect(): string
    {
        return join(PHP_EOL, [
        "FUNCTION fact(IN n: INTEGER): INTEGER",
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
                        new BinaryExpression(
                            Expression::OP_MULT,
                            new Variable("n"),
                            new FunctionCall("fact", new BinaryExpression(
                                Expression::OP_SUB,
                                new Variable("n"),
                                new Value(1)
                            ))
                        )
                    )
                )
            )
        );
    }
}
