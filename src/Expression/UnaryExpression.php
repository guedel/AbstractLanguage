<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Expression;

/**
 * Unary expression
 *
 * @author Guedel <guedel87@live.fr>
 */
class UnaryExpression extends Expression
{
    public function __construct(string $operator, private readonly Valuable $operand)
    {
        parent::__construct($operator);
    }

    public function getOperand(): Valuable
    {
        return $this->operand;
    }

    /**
     *
     * @param \Guedel\AL\Runtime\Visitor $visitor
     * @return mixed
     */
    public function evaluate(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->evalUnaryExpression($this);
    }
}
