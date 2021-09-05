<?php

  /*
   * The MIT License
   *
   * Copyright 2018 Guedel <guedel87@live.fr>.
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy
   * of this software and associated documentation files (the "Software"), to deal
   * in the Software without restriction, including without limitation the rights
   * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
   * copies of the Software, and to permit persons to whom the Software is
   * furnished to do so, subject to the following conditions:
   *
   * The above copyright notice and this permission notice shall be included in
   * all copies or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   * THE SOFTWARE.
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

    public function __construct(string $operator, Valuable ...$operands)
    {
        parent::__construct($operator);
        $this->operands = new ExpressionList(...$operands);
    }


    public function getOperands(): ExpressionList
    {
        return $this->operands;
    }

    public function evaluate(Visitor $visitor)
    {
        return $visitor->eval_binary_expression($this);
    }

    public function getPriority(): int
    {
        switch ($this->getOperator()) {
            case OP_MULT:
            case OP_DIV:
                return 5;
            case OP_ADD:
            case OP_SUB:
                return 4;
            case OP_EQUAL:
            case OP_DIFF:
            case OP_LT:
            case OP_GT:
            case OP_LTE:
            case OP_GTE:
                return 3;
            case OP_AND:
                return 2;
            case OP_OR:
            case OP_XOR:
                return 1;
            default:
                return 0;
        }
    }
}
