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

namespace Guedel\AL;

use Guedel\AL\Datatype\Type;
use Guedel\AL\Expression;
use Guedel\AL\Statement\StatementList;

/**
 * Build any class in Abstract Language
 *
 * @author Guedel <guedel87@live.fr>
 */
class Builder
{
  use Guedel\AL\Statement\StatementBuilder;
  use Guedel\AL\Expression\ExpressionBuilder;
  use Guedel\AL\Declaration\DeclarationBuilder;
  use Guedel\AL\Datatype\DataTypeBuilder;

  protected StatementList $statements;

  public function __construct(private readonly ?Builder $parent = null)
  {
    $this->statements = new StatementList();
  }

  public function getStatements(): StatementList
  {
    return $this->statements;
  }

  protected function stmtBegin(): Builder
  {
    $builder = new Builder();
    $builder->parent = $this;
    return $builder;
  }

  public function stmtEnd(): Builder
  {
    $ret = $this->parent;
    // $this->statements = null;
    $this->parent = null;
    return $ret;
  }
}
