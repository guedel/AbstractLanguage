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
 * Test of défined procedure with paramater
 *
 * @author Guedel <guedel87@live.fr>
 */
class ProcParamProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return "Hello World !";
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new Module(
            "helloProcedureWithParam",
            new ProcedureDecl(
                "hello",
                new ParametersList(new Parameter("name", "IN")),
                new ProcedureCall("PRINTF", new Value("Hello %s !"), new Variable("name"))
            ),
            new ProcedureCall("hello", new Value("World"))
        );
    }
}
