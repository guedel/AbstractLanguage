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

  namespace Guedel\AL\Declaration;

  use Guedel\AL\Statement\Statement;
  use Guedel\AL\Datatype\Type;
  use Guedel\AL\Runtime\Visitor;

  /**
   * FUNCTION $name ($arguments) : $returntype IS $body
   *
   * @author Guedel <guedel87@live.fr>
   */
class FunctionDecl extends ProcedureDecl
{
    private $returntype;


  public function __construct(string $name, Type $returntype, ParametersList $arguments = null, Statement $body = null)
  {
      parent::__construct($name, $arguments, $body);
      $this->returntype = $returntype;
  }

  public function getReturnType(): Type
  {
      return $this->returntype;
  }

  public function accept(Visitor $visitor)
  {
      return $visitor->declareFunction($this);
  }
}
