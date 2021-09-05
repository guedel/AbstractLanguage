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
  use Guedel\AL\Expression\Valuable;
  use Guedel\AL\Runtime\Visitor;

  /**
   * FOR $varname FROM $initial TO $final [STEP $increment] DO $statement
   *
   * @author Guedel <guedel87@live.fr>
   */
class ForStmt implements Statement
{
  private string $varname;
  private Valuable $initial;
  private Valuable $final;
  private Valuable $increment;
  private ?Statement $statement;

  public function __construct(
      string $varnmame,
      Valuable $initial,
      Valuable $final,
      Valuable $increment,
      Statement $statement = null
  ) {
      $this->varname = $varnmame;
      $this->initial = $initial;
      $this->final = $final;
      $this->increment = $increment;
      $this->statement = $statement;
  }

  public function accept(Visitor $visitor)
  {
      $visitor->visitForStmt($this);
  }

  public function getVariableName(): string
  {
      return $this->varname;
  }

  public function getInitial(): Valuable
  {
      return $this->initial;
  }

  public function getFinal(): Valuable
  {
      return $this->final;
  }

  public function getIncrement(): Valuable
  {
      return $this->increment;
  }

  public function getStatement(): ?Statement
  {
      return $this->statement;
  }
}
