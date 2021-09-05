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

use Datatype\Type;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\Valuable;
use Guedel\AL\Expression\Value;

/**
 * Build any class in Abstract Language
 *
 * @author Guedel <guedel87@live.fr>
 */
class Builder
{

  /**
   *
   * @var Statement\StatementList
   */
  private $statements;

  /**
   * @var Builder
   */
  private $parent;

  public function __construct()
  {
    $this->statements = new Statement\StatementList();
    $this->parent = null;
  }

  public function getStatements(): Statement\StatementList
  {
    return $this->statements;
  }

  public function stmtType(string $name, Datatype\Type $definition): Builder
  {
    $this->statements->add(new Declaration\TypeDecl($name, $definition));
    return $this;
  }

  public function stmtVariable(string $name, Type $type): Builder
  {
    $this->statements->add(new Declaration\VariableDecl($name, $type));
    return $this;
  }

  public function let(string $varname, Valuable $value): Builder
  {
    $this->statements->add(new Statement\AssignStmt($varname, $value));
    return $this;
  }

  public function stmtProcedure(string $name, Declaration\ParametersList $parameters = null): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\ProcedureDecl($name, $parameters, $ret->statements));
    return $ret;
  }

  public function stmtFunction(
      string $name,
      Type $return_type,
      Declaration\ParametersList
      $parameters = null): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\FunctionDecl($name, $return_type, $parameters, $ret->statements));
    return $ret;
  }

  public function stmtModule(string $name): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\Module($name, $ret->statements));
    return $ret;
  }

  public function stmtFor($varname, $init, $final, $step): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Statement\ForStmt($varname, $init, $final, $step, $ret->statements));
    return $ret;
  }

  public function stmtForEach($varname, $collection): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Statement\ForEachStmt($varname, $collection, $ret->statements));
    return $ret;
  }

  public function stmtIf($test): Builder
  {
    $then = $this->stmtBegin();
    $else = new Statement\StatementList();

    $this->statements->add(new Statement\IfThenStmt($test, $then->statements, $else));
    return $then;
  }

  public function stmtElse(): Builder
  {
    $me = $this->stmtEnd();
    $ret = $me->stmtBegin();
    $last = $me->statements->last();
    if ($last instanceof Statement\IfThenStmt) {
      $ret->statements = $last->getElsePart();
    }
    return $ret;
  }

  public function stmtWhile(Valuable $test): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Statement\WhileStmt($test, $ret->statements));
    return $ret;
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
    $this->statements = null;
    $this->parent = null;
    return $ret;
  }

  public function stmtCall($name, ...$args): Builder
  {
    $a = array();
    foreach ($args as $arg) {
      if ($arg instanceof Valuable) {
        $a[] = $arg;
      } else {
        $a[] = new Value($arg);
      }
    }
    $this->statements->add(new Statement\ProcedureCall($name, ... $a));
    return $this;
  }

}

// ========================
// expressions
// ========================
function fnExp(string $name, Valuable ...$args): Expression\FunctionCall
{
  return new Expression\FunctionCall($name, ... $args);
}

function addExp(Expression\Valuable ...$exp): BinaryExpression
{
  return new BinaryExpression(Expression::OP_ADD, ... $exp);
}

function subsExp(Expression\Valuable ...$exp): BinaryExpression
{
  return new BinaryExpression(Expression::OP_SUB, ... $exp);
}

function multExp(Expression\Valuable ...$exp): BinaryExpression
{
  return new BinaryExpression(Expression::OP_MULT, ... $exp);
}

function divExp(Expression\Valuable ...$exp): BinaryExpression
{
  return new BinaryExpression(Expression::OP_DIV, ... $exp);
}

function eqExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_EQUAL, $left, $right);
}

function ltExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_LT, $left, $right);
}

function lteExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_LTE, $left, $right);
}

function gtExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_GT, $left, $right);
}

function gteExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_GTE, $left, $right);
}

function diffExp(Valuable $left, Valuable $right): BinaryExpression
{
  return new BinaryExpression(Expression\Expression::OP_DIFF, $left, $right);
}

function v($val): Valuable
{
  return new Expression\Value($val);
}

// ========================
// data types
// ========================

function enumType(string ...$symbols): Datatype\Enumeration
{
  return new Datatype\Enumeration(...$symbols);
}

function arrayType($min, $max, Guedel\AL\Datatype\Type $type)
{
  return new Datatype\ArrayOf($type, $min, $max);
}

function stringType($len = null)
{
  return new Datatype\StringOfChars($len);
}
