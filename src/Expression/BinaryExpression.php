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

use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Runtime\Visitor;

/**
 * Description of BinaryExpression
 *
 * @author Guedel <guedel87@live.fr>
 */
class BinaryExpression extends Expression
{
    private readonly ExpressionList $operands;

    public function __construct(string $operator, Valuable $op1, Valuable $op2, Valuable ...$operands)
    {
        parent::__construct($operator);
        array_unshift($operands, $op1, $op2);
        $this->operands = new ExpressionList(...$operands);
    }


    public function getOperands(): ExpressionList
    {
        return $this->operands;
    }

    /**
     *
     * @param Visitor $visitor
     * @return mixed
     */
    public function evaluate(Visitor $visitor)
    {
        return $visitor->evalBinaryExpression($this);
    }

    public function getPriority(): int
    {
        return match ($this->getOperator()) {
            self::OP_MULT, self::OP_DIV => 5,
            self::OP_ADD, self::OP_SUB => 4,
            self::OP_EQUAL, self::OP_DIFF, self::OP_LT, self::OP_GT, self::OP_LTE, self::OP_GTE => 3,
            self::OP_AND => 2,
            self::OP_OR, self::OP_XOR => 1,
            default => 0,
        };
    }
}
