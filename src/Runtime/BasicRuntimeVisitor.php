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

use Guedel\AL\Statement\StatementList;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;

/**
 * Description of BasicRuntimeVisitor
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicRuntimeVisitor implements Visitor
{
  private BasicRuntimeContext $context;
  public function run(StatementList $statements)
  {
    $this->context = new BasicRuntimeContext();
    foreach ($statements as $stmt) {
      $stmt->accept($this);
    }
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
  public function declare_function(\Guedel\AL\Declaration\FunctionDecl $decl)
  {
    $this->context->addFunction($decl);
  }

  public function declare_module(\Guedel\AL\Declaration\Module $decl)
  {
    $this->pushContext($decl->getName());
    foreach ($decl->getStatements() as $stmt) {
      $stmt->accept($this);
    }
    $this->popContext();
  }

  public function declare_parameter(\Guedel\AL\Declaration\Parameter $decl)
  {
    $this->context->addVariable($decl);
  }

  public function declare_procedure(\Guedel\AL\Declaration\ProcedureDecl $decl)
  {
    $this->context->addProcedure($decl);
  }

  public function declare_type(\Guedel\AL\Declaration\TypeDecl $decl)
  {
    $this->context->addType($decl);
  }

  public function declare_variable(VariableDecl $decl)
  {
    $this->context->addVariable($decl);
  }

  public function eval_binary_expression(BinaryExpression $exp)
  {
    $first = true;
    $acc = null;
    foreach ($exp->getOperands() as $op) {
      if ($first) {
        $acc = $op;
        $prev = $op;
        $first = false;
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
            $acc = $acc && $prev == $op;
                break;
          case Expression::OP_DIFF:
            // a != b != c <=> a != b AND b != c
            $acc = $acc && $prev != $op;
                break;
          case Expression::OP_LT:
            // a < b < c <=> a < b AND b < c
            $acc = $acc && $prev < $op;
                break;
          case Expression::OP_GT:
            $acc = $acc && $prev > $op;
                break;
          case Expression::OP_LTE:
            $acc = $acc && $prev <= $op;
                break;
          case Expression::OP_GTE:
            $acc = $acc && $prev >= $op;
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
      }
    }
    return $acc;
  }

  public function eval_function_call(\Guedel\AL\Expression\FunctionCall $fn)
  {
    $name = $fn->getName();

    if (function_exists($name)) {
      // call of PHP function
      return ;
    }
    $func = $this->context->findFunction($name);
    if ($func === null) {
      throw new NotFoundException("function $name not found in this scope");
    }

    $this->pushContext($name);
    // Les arguments
    $itParams = $func->getParameters()->getIterator();
    foreach ($fn->getParameters() as $param) {
      if ($itParams->valid()) {
        $var = new VariableDecl($itParams->getName(), $itParams->getType);
        $var->setValue($param->getValue());
        $this->context->addVariable($var);
      }
      $itParams->next();
    }

    // Appel des instructions de la fonction
    $func->getBody()->accept($this);
    $this->popContext();
  }

  public function eval_unary_expression(\Guedel\AL\Expression\UnaryExpression $exp)
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

  public function eval_value(\Guedel\AL\Expression\Value $value)
  {
    return $value->getValue();
  }

  public function eval_variable(\Guedel\AL\Expression\Variable $variable)
  {
    $name = $variable->get_varname();
    $v = $this->context->findVariable($name);
    if (! $v === null) {
      throw new NotFoundException("variable $name not found in this scope");
    }
  }

  public function visit_any(\Guedel\AL\Datatype\Any $type)
  {
  }

  public function visit_arrayof(\Guedel\AL\Datatype\ArrayOf $type)
  {
  }

  public function visit_assign_stmt(\Guedel\AL\Statement\AssignStmt $stmt)
  {
  }

  public function visit_class(\Guedel\AL\Datatype\ClassType $type)
  {
    // TODO
  }

  public function visit_comment(\Guedel\AL\Statement\Comment $stmt)
  {
    // do nothing
  }

  public function visit_enumeration(\Guedel\AL\Datatype\Enumeration $type)
  {
  }

  public function visit_for_each_stmt(\Guedel\AL\Statement\ForEachStmt $stmt)
  {
  }

  public function visit_for_stmt(\Guedel\AL\Statement\ForStmt $stmt)
  {
  }

  public function visit_if_then_stmt(\Guedel\AL\Statement\IfThenStmt $stmt)
  {
    $test = $stmt->get_iftest()->evaluate($this);
    if ($test) {
      return $stmt->get_then_part()->accept($this);
    } else {
      $elsePart = $stmt->get_else_part();
      if ($elsePart) {
        return $elsePart->accept($this);
      }
      return;
    }
  }

  public function visit_number(\Guedel\AL\Datatype\Number $type)
  {
  }

  public function visit_procedure_call(\Guedel\AL\Statement\ProcedureCall $proc)
  {
  }

  public function visit_reference(\Guedel\AL\Datatype\Reference $type)
  {
  }

  public function visit_return_stmt(\Guedel\AL\Statement\ReturnStmt $stmt)
  {
    $value = [];
    foreach ($stmt->getExpressions() as $expr) {
      $value[] = $expr->eval($this);
    }
    return $value;
  }

  public function visit_statement_list(\Guedel\AL\Statement\StatementList $stmt)
  {
    foreach ($stmt as $s) {
      $s->accept($this);
    }
  }

  public function visit_string(\Guedel\AL\Datatype\StringOfChars $type)
  {
  }

  public function visit_structure(\Guedel\AL\Datatype\Structure $type)
  {
  }

  public function visit_typename(\Guedel\AL\Datatype\TypeName $type)
  {
  }

  public function visit_while_stmt(\Guedel\AL\Statement\WhileStmt $stmt)
  {
    $test = $stmt->get_test();
    while ($test->evaluate($this)) {
      $stmt->get_statement()->accept($this);
    }
  }
}
