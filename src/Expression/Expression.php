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
    const OP_ADD = '+';
    const OP_SUB = '-';
    const OP_MULT = '*';
    const OP_DIV = '/';
    const OP_EQUAL = '==';
    const OP_DIFF = '!=';
    const OP_LT = '<';
    const OP_GT = '>';
    const OP_LTE = '<=';
    const OP_GTE = '>=';
    const OP_NOT = '!';
    const OP_OR = '|';
    const OP_AND = '&';
    const OP_XOR = '^';

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
