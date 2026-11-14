<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Statement;

use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Runtime\Visitor;
use Guedel\AL\Expression\Valuable;

/**
 * Return $expressions
 *
 * @author Guedel <guedel87@live.fr>
 */
class ReturnStmt implements Statement
{
    private $expressions;

    public function __construct(Valuable ...$expressions)
    {
        $this->expressions = new ExpressionList(... $expressions);
    }

    public function getExpressions(): ExpressionList
    {
        return $this->expressions;
    }


    public function accept(Visitor $visitor)
    {
        return $visitor->visitReturnStmt($this);
    }
}
