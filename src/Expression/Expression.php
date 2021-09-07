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
