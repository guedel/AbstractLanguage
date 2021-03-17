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

  use Guedel\AL\Expression\Expression;
  use \Guedel\AL\Runtime\Visitor;

  /**
   * FOR $varname FROM $initial TO $final [STEP $increment] DO $statement
   *
   * @author Guedel <guedel87@live.fr>
   */
  class ForStmt implements Statement
  {
    private string $varname;
    private Expression $initial;
    private Expression $final;
    private Expression $increment;
    private ?Statement $statement;

    public function __construct(string $varnmame,
        Expression $initial,
        Expression $final,
        Expression $increment,
        Statement $statement = null)
    {
      $this->varname = $varnmame;
      $this->initial = $initial;
      $this->final = $final;
      $this->increment = $increment;
      $this->statement = $statement;
    }

    public function accept(Visitor $visitor)
    {
      $visitor->visit_for_stmt($this);
    }

    public function get_variable_name() : string
    {
      return $this->varname;
    }

    public function get_initial(): Expression
    {
      return $this->initial;
    }

    public function get_final(): Expression
    {
      return $this->final;
    }

    public function get_increment(): Expression
    {
      return $this->increment;
    }

    public function get_statement() : ?Statement
    {
      return $this->statement;
    }
  }
