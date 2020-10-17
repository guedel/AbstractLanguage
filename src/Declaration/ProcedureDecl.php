<?php

  /*
   * The MIT License
   *
   * Copyright 2018 Guillaume de Lestanville <guillaume.delestanville@proximit.fr>.
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

   namespace guedel\AL\Declaration;

   /**
   * Description of ProcedureDecl
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class ProcedureDecl extends NamedDeclaration
  {
    /**
     *
     * @var ParametersList
     */
    private $parameters;
    /**
     * @var Statement
     */
    private $body;

    public function __construct(string $name, ParametersList $parameters = null, Statement $body = null)
    {
      parent::__construct($name);
      $this->parameters = $parameters;
      if ($body instanceof \guedel\AL\Statement\StatementList) {
        $this->body = $body;
      } else {
        $this->body = new \guedel\AL\Statement\StatementList($body);
      }
    }

    public function accept(\guedel\AL\Runtime\Visitor $visitor)
    {
      $visitor->declare_procedure($this);
    }

    public function get_parameters(): ParametersList
    {
      return $this->parameters;
    }

    public function get_body(): \guedel\AL\Statement\StatementList
    {
      return $this->body;
    }
  }