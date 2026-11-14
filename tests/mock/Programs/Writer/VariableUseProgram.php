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
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Value;
use Guedel\AL\Datatype\Any;

/**
 * Description of VariableUseProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class VariableUseProgram implements BaseTestProgram
{
    /**
     * @inherit
     */
    public function expect(): string
    {
        return join(PHP_EOL, [
        "VAR i: ANY",
        "i <- 10",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new StatementList(
            new VariableDecl("i"),
            new AssignStmt("i", new Value(10))
        );
    }
}
