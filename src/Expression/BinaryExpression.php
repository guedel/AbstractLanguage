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
    private ExpressionList $operands;

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
        switch ($this->getOperator()) {
            case self::OP_MULT:
            case self::OP_DIV:
                return 5;
            case self::OP_ADD:
            case self::OP_SUB:
                return 4;
            case self::OP_EQUAL:
            case self::OP_DIFF:
            case self::OP_LT:
            case self::OP_GT:
            case self::OP_LTE:
            case self::OP_GTE:
                return 3;
            case self::OP_AND:
                return 2;
            case self::OP_OR:
            case self::OP_XOR:
                return 1;
            default:
                return 0;
        }
    }
}
