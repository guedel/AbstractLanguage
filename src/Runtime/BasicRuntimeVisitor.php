<?php

/*
 * The MIT License
 *
 * Copyright 2021 Guedel <guedel87@live.fr>.
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

namespace Guedel\AL\Runtime;

use Guedel\AL\Statement\Statement;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Valuable;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Exception\InvalidOperatorException;
use Guedel\AL\Exception\NotFoundException;
use Guedel\AL\Exception\EndlessLoopException;

/**
 * Description of BasicRuntimeVisitor
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicRuntimeVisitor implements Visitor
{

  private BasicRuntimeContext $context;

  private function debug($output)
  {
    $f = fopen("test.out", "a+");
    fwrite($f, $output . PHP_EOL);
    fclose($f);
  }

  public function run(Statement $statement)
  {
    $this->context = new BasicRuntimeContext();
    $statement->accept($this);
  }

  private function pushContext(string $name = null)
  {
    $context = new BasicRuntimeContext($this->context, $name);
    $this->context = $context;
  }

  private function popContext()
  {
    $context = $this->context;
    $this->context = $context->getParent();
  }

  //put your code here
  public function declareFunction(\Guedel\AL\Declaration\FunctionDecl $decl)
  {
    $this->context->addFunction($decl);
  }

  public function declareModule(\Guedel\AL\Declaration\Module $decl)
  {
    $this->pushContext($decl->getName());
    foreach ($decl->getStatements() as $stmt) {
      $stmt->accept($this);
    }
    $this->popContext();
  }

  public function declareParameter(\Guedel\AL\Declaration\Parameter $decl)
  {
    $this->context->addVariable($decl);
  }

  public function declareProcedure(\Guedel\AL\Declaration\ProcedureDecl $decl)
  {
    $this->context->addProcedure($decl);
  }

  public function declareType(\Guedel\AL\Declaration\TypeDecl $decl)
  {
    $this->context->addType($decl);
  }

  public function declareVariable(VariableDecl $decl)
  {
    $this->context->addVariable($decl);
  }

  public function evalBinaryExpression(BinaryExpression $exp)
  {
    $first = true;
    $second = false;
    $acc = null;
    foreach ($exp->getOperands() as $operand) {
      $op = $operand->evaluate($this);
      if ($first) {
        $acc = $op;
        $first = false;
        $second = true;
      } else {
        switch ($exp->getOperator()) {
          case Expression::OP_ADD:
            $acc += $op;
              break;
          case Expression::OP_SUB:
            $acc -= $op;
              break;
          case Expression::OP_MULT:
            $acc *= $op;
              break;
          case Expression::OP_DIV:
            $acc /= $op;
              break;
          case Expression::OP_EQUAL:
            // a = b = c <=> a = b AND b = c
            if ($second) {
              $acc = $prev == $op;
            } else {
              $acc = $acc && $prev == $op;
            }
              break;
          case Expression::OP_DIFF:
            // a != b != c <=> a != b AND b != c
            if ($second) {
              $acc = $prev != $op;
            } else {
              $acc = $acc && $prev != $op;
            }
              break;
          case Expression::OP_LT:
            // a < b < c <=> a < b AND b < c
            if ($second) {
              $acc = $prev < $op;
            } else {
              $acc = $acc && $prev < $op;
            }
              break;
          case Expression::OP_GT:
            if ($second) {
              $acc = $prev > $op;
            } else {
              $acc = $acc && $prev > $op;
            }
              break;
          case Expression::OP_LTE:
            if ($second) {
              $acc = $prev <= $op;
            } else {
              $acc = $acc && $prev <= $op;
            }
              break;
          case Expression::OP_GTE:
            if ($second) {
              $acc = $prev >= $op;
            } else {
              $acc = $acc && $prev >= $op;
            }
              break;
          case Expression::OP_OR:
            $acc |= $op;
              break;
          case Expression::OP_AND:
            $acc &= $op;
              break;
          case Expression::OP_XOR:
            $acc ^= $op;
              break;
          default:
              throw new InvalidOperatorException();
        }
        $second = false;
      }
      $prev = $op;
    }
    return $acc;
  }

  public function evalFunctionCall(\Guedel\AL\Expression\FunctionCall $fn)
  {
    $name = strtolower($fn->getName());

    $func = $this->context->findFunction($name);
    if ($func === null) {
      if (function_exists($name)) {
        // call of PHP function
        return $this->phpFunction($fn);
      }
      throw new NotFoundException("function $name not found in this scope");
    }

    $this->pushContext($name);
    // Les arguments
    $itParams = $func->getParameters()->getIterator();
    foreach ($fn->getParameters() as $param) {
      if ($itParams->valid()) {
        $var = new VariableDecl($itParams->current()->getName(), $itParams->current()->getType());
        $var->setValue($param->getValue());
        $this->context->addVariable($var);
      }
      $itParams->next();
    }

    // Appel des instructions de la fonction
    $func->getBody()->accept($this);
    $return = [];
    if ($this->context->isReturnRequest()) {
      $return = $this->context->getReturnValues();
    }
    $this->popContext();
    // $this->debug(print_r($return, true));
    // At this time only one return value is supported
    if (isset($return[0])) {
      return $return[0];
    }
    return null;
  }

  public function evalUnaryExpression(\Guedel\AL\Expression\UnaryExpression $exp)
  {
    switch ($exp->getOperator()) {
      case Expression::OP_ADD:
          return $exp->getOperand()->evaluate($this);
      case Expression::OP_NOT:
          return $exp->getOperand()->evaluate($this);
      case Expression::OP_SUB:
          return - $exp->getOperand()->evaluate($this);
      default:
          throw new InvalidOperatorException();
    }
  }

  public function evalValue(\Guedel\AL\Expression\Value $value)
  {
    return $value->getValue();
  }

  public function evalVariable(\Guedel\AL\Expression\Variable $variable)
  {
    $name = $variable->getVarname();
    $v = $this->context->findVariable($name);
    if ($v === null) {
      throw new NotFoundException("variable $name not found in this scope");
    }
    return $v->getValue()->evaluate($this);
  }

  public function visitAny(\Guedel\AL\Datatype\Any $type)
  {
  }

  public function visitArrayof(\Guedel\AL\Datatype\ArrayOf $type)
  {
  }

  public function visitAssignStmt(\Guedel\AL\Statement\AssignStmt $stmt)
  {
    $name = $stmt->getVariableName();
    $v = $this->context->findVariable($name);
    if ($v === null) {
      throw new NotFoundException("variable $name not found in this scope");
    }
    $value = $stmt->getExpression()->evaluate($this);
    $v->setValue($value);
  }

  public function visitClass(\Guedel\AL\Datatype\ClassType $type)
  {
    // TODO
  }

  public function visitComment(\Guedel\AL\Statement\Comment $stmt)
  {
    // do nothing
  }

  public function visitEnumeration(\Guedel\AL\Datatype\Enumeration $type)
  {
  }

  public function visitForEachStmt(\Guedel\AL\Statement\ForEachStmt $stmt)
  {
  }

  public function visitForStmt(\Guedel\AL\Statement\ForStmt $stmt)
  {
    $name = $stmt->getVariableName();
    $var = $this->context->findVariable($name);
    if ($var === null) {
      // variable must be declared
      throw new NotFoundException("variable $name not found in this scope");
    }

    $start = $stmt->getInitial()->evaluate($this);
    $final = $stmt->getFinal()->evaluate($this);
    $increment = $stmt->getIncrement()->evaluate($this);
    if ($increment > 0) {
      for (
          $var->setValue($start);
          $var->getValue()->evaluate($this) <= $final;
          $var->setValue($var->getValue()->evaluate($this) + $increment)
      ) {
        $stmt->getStatement()->accept($this);
      }
    } elseif ($increment < 0) {
      for (
          $var->setValue($start);
          $var->getValue()->evaluate($this) >= $final;
          $var->setValue($var->getValue()->evaluate($this) + $increment)
      ) {
        $stmt->getStatement()->accept($this);
      }
    } else {
      throw new EndlessLoopException();
    }
  }

  public function visitIfThenStmt(\Guedel\AL\Statement\IfThenStmt $stmt)
  {
    $test = $stmt->getIfTest()->evaluate($this);
    if ($test) {
      return $stmt->getThenPart()->accept($this);
    } else {
      $elsePart = $stmt->getElsePart();
      if ($elsePart) {
        return $elsePart->accept($this);
      }
      return;
    }
  }

  public function visitNumber(\Guedel\AL\Datatype\Number $type)
  {
  }

  public function visitProcedureCall(\Guedel\AL\Statement\ProcedureCall $proc)
  {
    if ($this->internalCommand($proc)) {
      return;
    }
    $name = strtolower($proc->getName());
    $pf = $this->context->findProcedure($name);
    if ($pf === null) {
      if (function_exists($name)) {
        $this->phpProcedure($proc);
        return;
      }
      throw new NotFoundException("procedure $name not found in this scope");
    }

    $this->pushContext($name);
    // Les arguments
    $itParams = $pf->getParameters()->getIterator();
    foreach ($proc->getParameters() as $param) {
      if ($itParams->valid()) {
        // $this->debug(print_r($itParams, true));
        $var = new VariableDecl($itParams->current()->getName(), $itParams->current()->getType());
        $var->setValue($param->getValue());
        $this->context->addVariable($var);
      }
      $itParams->next();
    }

    // Appel des instructions de la fonction
    $pf->getBody()->accept($this);
    $this->popContext();
  }

  public function visitReference(\Guedel\AL\Datatype\Reference $type)
  {
  }

  /**
   * Return an array of values if multiple expressions
   * @param \Guedel\AL\Statement\ReturnStmt $stmt
   */
  public function visitReturnStmt(\Guedel\AL\Statement\ReturnStmt $stmt)
  {
    $value = [];
    foreach ($stmt->getExpressions() as $expr) {
      $value[] = $expr->evaluate($this);
    }
    $this->context->setReturnRequest(true, ...$value);
  }

  public function visitStatementList(\Guedel\AL\Statement\StatementList $stmt)
  {
    foreach ($stmt as $s) {
      $s->accept($this);
      if ($this->context->isReturnRequest()) {
        return;
      }
    }
  }

  public function visitString(\Guedel\AL\Datatype\StringOfChars $type)
  {
  }

  public function visitStructure(\Guedel\AL\Datatype\Structure $type)
  {
  }

  public function visitTypename(\Guedel\AL\Datatype\TypeName $type)
  {
  }

  public function visitWhileStmt(\Guedel\AL\Statement\WhileStmt $stmt)
  {
    $test = $stmt->getTest();
    while ($test->evaluate($this)) {
      $stmt->getStatement()->accept($this);
    }
  }

  /**
   *
   * @param \Guedel\AL\Statement\ProcedureCall $proc
   * @return bool true if internal procédure found
   */
  private function internalCommand(\Guedel\AL\Statement\ProcedureCall $proc): bool
  {
    // TODO remplacer par un mapping
    $name = strtolower($proc->getName());
    if ($name === 'write' || $name === 'writeln') {
      foreach ($proc->getParameters() as $p) {
        if ($p instanceof Valuable) {
          echo $p->evaluate($this);
        }
      }
      if ($name === 'writeln') {
        echo PHP_EOL;
      }
      return true;
    }
    return false;
  }

  private function phpProcedure(\Guedel\AL\Statement\ProcedureCall $proc): void
  {
    call_user_func_array($proc->getName(), $this->builParametersArray($proc->getParameters()));
  }

  private function phpFunction(\Guedel\AL\Expression\FunctionCall $func)
  {
    return call_user_func_array($func->getName(), $this->builParametersArray($func->getParameters()));
  }

  private function builParametersArray(\Guedel\AL\Expression\ExpressionList $list): array
  {
    $params = [];
    foreach ($list as $param) {
      if ($param instanceof Valuable) {
        $params[] = $param->evaluate($this);
      }
    }
    return $params;
  }
}
