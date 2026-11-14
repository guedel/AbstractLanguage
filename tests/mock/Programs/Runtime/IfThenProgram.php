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
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Expression;

/**
 * Test of "if then" structure
 *
 * @author Guedel <guedel87@live.fr>
 */
class IfThenProgram implements BaseTestProgram
{
    //put your code here
    public function code(): Statement
    {
        return new Module(
            "ifthen",
            new IfThenStmt(new Value(true), new ProcedureCall("writeln", new Value("OK"))),
            new IfThenStmt(
                new Value(false),
                new ProcedureCall("writeln", new Value("OK")),
                new ProcedureCall("writeln", new Value("KO"))
            )
        );
    }

    public function expect(): string
    {
        return
        "OK" . PHP_EOL
        . "KO" . PHP_EOL;
    }
}
