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

use Guedel\AL\Expression\Expression;
use Guedel\AL\Runtime\Visitor;

/**
 * Description of EmptyExpression
 *
 * @author Guedel <guedel87@live.fr>
 */
class EmptyExpression extends Expression
{
    public function __construct()
    {
        parent::__construct('$');
    }
    public function evaluate(Visitor $visitor)
    {
        return 10;
    }
}
