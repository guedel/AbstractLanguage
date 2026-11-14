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

/**
 * Test of call of internal functions of PHP
 *
 * @author Guedel <guedel87@live.fr>
 */
class PrintfProgram implements BaseTestProgram
{
    public function expect(): string
    {
        return "Hello World !";
    }

    public function code(): Statement
    {
        return new Module(
            "Hello",
            new ProcedureCall("printf", new Value("Hello %s !"), new Value("World"))
        );
    }
}
