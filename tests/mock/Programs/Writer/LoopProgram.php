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
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Statement\{WhileStmt, ForStmt, ForEachStmt, StatementList, ProcedureCall};
use Guedel\AL\Expression\{Value, Variable};
use Guedel\AL\Datatype\ArrayOf;
use Guedel\AL\Datatype\Any;

/**
 * Description of LoopProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class LoopProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return join(PHP_EOL, [
        "WHILE i DO",
        "\tDEC i",
        "END WHILE",
        "FOR i FROM 1 TO 10 STEP 1 DO",
        "\tWRITE i",
        "END FOR",
        "VAR arr: ARRAY OF ANY",
        "FOR EACH item IN arr DO",
        "\tWRITE item",
        "END FOR",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new StatementList(
            new WhileStmt(
                new Variable("i"),
                new ProcedureCall("DEC", new Variable("i"))
            ),
            new ForStmt(
                "i",
                new Value(1),
                new Value(10),
                new Value(1),
                new ProcedureCall("WRITE", new Variable("i"))
            ),
            new VariableDecl("arr", new ArrayOf(Any::getType())),
            new ForEachStmt(
                "item",
                new Variable("arr"),
                new ProcedureCall("WRITE", new Variable("item"))
            )
        );
    }
}
