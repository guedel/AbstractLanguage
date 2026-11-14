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
use Guedel\AL\Declaration\Module;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\{Parameter, ParametersList};
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Expression\Value;

/**
 *
 *
 * @author Guedel <guedel87@live.fr>
 */
class ProcProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return "Hello World !";
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new Module(
            "simpleHelloProcedure",
            new ProcedureDecl(
                "hello",
                null,
                new ProcedureCall("WRITE", new Value("Hello World !"))
            ),
            new ProcedureCall("hello")
        );
    }
}
