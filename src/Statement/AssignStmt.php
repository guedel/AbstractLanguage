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

use Guedel\AL\Expression\Valuable;
use Guedel\AL\Runtime\Visitor;

/**
 * $varname <- $expression
 *
 * @author Guedel <guedel87@live.fr>
 */
class AssignStmt implements Statement
{
    public function __construct(
        private readonly string $varname,
        private readonly Valuable $expression,
    ) {
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitAssignStmt($this);
    }

    public function getVariableName(): string
    {
        return $this->varname;
    }

    public function getExpression(): Valuable
    {
        return $this->expression;
    }
}
