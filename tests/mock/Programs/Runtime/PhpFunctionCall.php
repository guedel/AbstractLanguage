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
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Expression\Value;

/**
 * Test of call of php function
 *
 * @author Guedel <guedel87@live.fr>
 */
class PhpFunctionCall implements BaseTestProgram
{
    public function code(): Statement
    {
        return new Module(
            "phpfunctioncall",
            new ProcedureCall("write", new FunctionCall("sprintf", new Value("Hello %s !"), new Value("World")))
        );
    }

    public function expect(): string
    {
        return "Hello World !";
    }
}
