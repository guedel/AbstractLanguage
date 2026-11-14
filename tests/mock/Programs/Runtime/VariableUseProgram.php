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
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;

/**
 * Description of VariableUseProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class VariableUseProgram implements BaseTestProgram
{
    public function code(): Statement
    {
        return new Module(
            'varUse',
            new VariableDecl('v'),
            new AssignStmt('v', new Value("Hello World !")),
            new ProcedureCall('write', new Variable('v'))
        );
    }

    public function expect(): string
    {
        return "Hello World !";
    }
}
