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

  namespace Guedel\AL\Statement;

  use Guedel\AL\Expression\ExpressionList;
  use Guedel\AL\Expression\Valuable;
  use Guedel\AL\Runtime\Visitor;

  /**
   * Call $name With $parameters
   *
   * @author Guedel <guedel87@live.fr>
   */
class ProcedureCall implements Statement
{
    private $name;
    private $parameters;

  public function __construct(string $name, Valuable ...$parameters)
  {
      $this->name = $name;
      $this->parameters = new ExpressionList(... $parameters);
  }
    //put your code here
  public function accept(Visitor $visitor)
  {
      $visitor->visitProcedureCall($this);
  }

  public function getName(): string
  {
      return $this->name;
  }

  public function getParameters(): ExpressionList
  {
      return $this->parameters;
  }
}
