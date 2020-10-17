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

  namespace guedel\AL\Statement;

  /**
   * FOR EACH $varname IN $collection
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class ForEachStmt implements Statement
  {
    private $varname;
    private $collection;
    private $statement;

    public function __construct(string $varname, \guedel\AL\Expression\Expression $collection, \guedel\AL\Statement\Statement $stmt = null)
    {
      $this->varname = $varname;
      $this->collection = $collection;
      $this->statement = $stmt;
    }

    public function get_varname(): string
    {
      return $this->varname;
    }

    public function get_collection(): \guedel\AL\Expression\Expression
    {
      return $this->collection;
    }

    public function get_statement(): Statement
    {
      return $this->statement;
    }

    public function accept(\guedel\AL\Runtime\Visitor $visitor)
    {
      $visitor->visit_for_each_stmt($this);
    }

  }