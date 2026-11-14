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
use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Datatype\Any;

/**
 * Test return of function without parameter
 *
 * @author Guedel <guedel87@live.fr>
 */
class FuncProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return "Hello World !";
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new Module(
            "simpleHelloFunction",
            new FunctionDecl("hello", Any::getType(), null, new ReturnStmt(new Value("Hello World !"))),
            new ProcedureCall("WRITE", new FunctionCall("hello"))
        );
    }
}
