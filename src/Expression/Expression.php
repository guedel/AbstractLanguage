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
 * abstract base of an expression
 *
 * @author Guedel <guedel87@live.fr>
 */
abstract class Expression implements Valuable
{
    public const OP_ADD = '+';
    public const OP_SUB = '-';
    public const OP_MULT = '*';
    public const OP_DIV = '/';
    public const OP_EQUAL = '==';
    public const OP_DIFF = '!=';
    public const OP_LT = '<';
    public const OP_GT = '>';
    public const OP_LTE = '<=';
    public const OP_GTE = '>=';
    public const OP_NOT = '!';
    public const OP_OR = '|';
    public const OP_AND = '&';
    public const OP_XOR = '^';

    private string $operator;

    protected function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
