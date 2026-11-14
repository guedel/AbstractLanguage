<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Mock\AL;

use Guedel\AL\Statement\Statement;
use Guedel\AL\Runtime\Visitor;

/**
 * Description of EmptyStatement
 *
 * @author Guedel <guedel87@live.fr>
 */
class EmptyStatement implements Statement
{
    //put your code here
    public function accept(Visitor $visitor)
    {
        return 'EMPTY';
    }
}
