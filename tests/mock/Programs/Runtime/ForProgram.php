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
use Guedel\AL\Statement\ForStmt;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;

/**
 * Description of ForProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class ForProgram implements BaseTestProgram
{
    //put your code here
    public function code(): Statement
    {
        return new Module(
            "forstmt",
            new VariableDecl('i'),
            new ForStmt(
                'i',
                new Value(1),
                new Value(5),
                new Value(1),
                new ProcedureCall('writeln', new Variable('i'))
            ),
            new ForStmt(
                'i',
                new Value(5),
                new Value(1),
                new Value(-1),
                new ProcedureCall('writeln', new Variable('i'))
            )
        );
    }

    public function expect(): string
    {
        return join(PHP_EOL, [1,2,3,4,5,5,4,3,2,1]) . PHP_EOL;
    }
}
