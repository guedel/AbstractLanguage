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
use Guedel\AL\Datatype\{Structure, TypeName, Any};
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Declaration\TypeDecl;

/**
 * Description of ClassProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class StructProgram implements BaseTestProgram
{
    public function expect(): string
    {
        return join(PHP_EOL, [
        "TYPE mystruct: STRUCT",
        "\tVAR one: ANY",
        "\tVAR two: INTEGER",
        "END STRUCT",
        ]) . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new TypeDecl(
            "mystruct",
            new Structure(
                new VariableDecl("one", Any::getType()),
                new VariableDecl("two", new TypeName("int"))
            )
        );
    }
}
