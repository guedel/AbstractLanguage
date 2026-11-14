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
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\{Parameter, ParametersList};
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Expression\Variable;

/**
 * Description of DeclareProcProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class DeclareProcProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return join(PHP_EOL, [
        "PROCEDURE bonjour(IN name: ANY)",
        "\tWRITE name",
        "END PROCEDURE",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new ProcedureDecl(
            "bonjour",
            new ParametersList(new Parameter("name", "IN")),
            new ProcedureCall("WRITE", new Variable("name"))
        );
    }
}
