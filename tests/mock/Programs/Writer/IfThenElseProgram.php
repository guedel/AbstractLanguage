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
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Expression\Value;

/**
 * Description of IfThenElseProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class IfThenElseProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return join(PHP_EOL, [
        "IF \"a\" THEN",
        "\tWRITE \"OK\"",
        "ELSE",
        "\tWRITE \"NOT OK\"",
        "END IF",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new IfThenStmt(
            new Value("a"),
            new ProcedureCall("WRITE", new Value("OK")),
            new ProcedureCall("WRITE", new Value("NOT OK"))
        );
    }
}
