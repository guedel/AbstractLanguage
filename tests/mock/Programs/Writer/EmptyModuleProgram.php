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

/**
 * Description of EmptyModuleProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class EmptyModuleProgram implements BaseTestProgram
{
    //put your code here
    public function expect(): string
    {
        return "MODULE Empty" . PHP_EOL . "END MODULE" . PHP_EOL;
    }

    public function code(): \Guedel\AL\Statement\Statement
    {
        return new \Guedel\AL\Declaration\Module('Empty');
    }
}
