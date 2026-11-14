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
use Guedel\AL\Declaration\Module;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Expression\Value;

/**
 * Description of HelloWorldProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class HelloWorldProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return join(PHP_EOL, [
        "MODULE Hello",
        "\tWRITE \"Hello World !\"",
        "END MODULE",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new Module(
            "Hello",
            new ProcedureCall("WRITE", new Value("Hello World !"))
        );
    }
}
