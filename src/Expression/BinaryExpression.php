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
