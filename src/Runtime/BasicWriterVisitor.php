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

namespace Guedel\AL\Runtime;

use \Guedel\Stream\CodeWriter;
use \Guedel\AL\Runtime\Translator;

/**
 * Write structure as pseudo-code
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicWriterVisitor implements Visitor
{

  /**
   *
   * @var CodeWriter
   */
  private $writer;
  private Translator $translator;

  public function __construct(?CodeWriter $writer = null, ?Translator $translator = null)
  {
    if ($writer === null) {
      $this->writer = new CodeWriter();
    } else {
      $this->writer = $writer;
    }
    if ($translator === null) {
      $this->translator = new Translator();
    } else {
      $this->translator = $translator;
    }
  }

  public function walk(\Guedel\AL\Statement\Statement $grammar)
  {
    $grammar->accept($this);
  }

  public function declare_function(\Guedel\AL\Declaration\FunctionDecl $decl)
  {
    $this->writer->out($this->t('FUNCTION') . ' ' . $decl->getName() . '(');
    $first = true;
    foreach ($decl->getParameters() as $parameter) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(', ');
      }
      $parameter->accept($this);
    }
    $this->writer->out('): ');

    $decl->get_returntype()->accept($this);
    $this->writer->nl();
    $this->writer->indent();

    $decl->getBody()->accept($this);
    $this->writer->unindent();
    $this->writer->outln($this->t('END') . ' ' . $this->t('FUNCTION'));
  }

  public function declare_module(\Guedel\AL\Declaration\Module $decl)
  {
    $this->writer->outln($this->t('MODULE') . ' ' . $decl->getName());
    $this->writer->indent();
    foreach ($decl->getStatements() as $statement) {
      $statement->accept($this);
    }
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'MODULE'));
  }

  public function declare_parameter(\Guedel\AL\Declaration\Parameter $decl)
  {
    $this->writer->out($decl->getDirection() . ' ');
    $this->writer->out($decl->getName());
    $this->writer->out(': ');
    $decl->get_type()->accept($this);
  }

  public function declare_procedure(\Guedel\AL\Declaration\ProcedureDecl $decl)
  {
    $this->writer->out($this->t('PROCEDURE') . ' ' . $decl->getName() . '(');
    $first = true;
    foreach ($decl->getParameters() as $parameter) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(', ');
      }
      $parameter->accept($this);
    }
    $this->writer->outln(")");
    $this->writer->indent();

    $decl->getBody()->accept($this);
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'PROCEDURE'));
  }

  public function declare_type(\Guedel\AL\Declaration\TypeDecl $decl)
  {
    $this->writer->out($this->t('TYPE') . ' ' . $decl->getName());
    $this->writer->out(': ');
    $decl->get_definition()->accept($this);
    $this->writer->nl();
  }

  public function declare_variable(\Guedel\AL\Declaration\VariableDecl $decl)
  {
    $this->writer->out($this->t('VAR') . ' ' . $decl->getName());
    $this->writer->out(': ');
    $decl->get_type()->accept($this);
    $this->writer->nl();
  }

  public function eval_binary_expression(\Guedel\AL\Expression\BinaryExpression $exp)
  {
    $first = true;
    foreach ($exp->getOperands() as $op) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(' ' . $exp->getOperator() . ' ');
      }
      $parenthesis = false;
      if ($op instanceof \Guedel\AL\Expression\BinaryExpression) {
        if ($op->getPriority() < $exp->getPriority()) {
          $parenthesis = true;
          $this->writer->out("(");
        }
      }
      $op->evaluate($this);
      if ($parenthesis) {
        $this->writer->out(")");
      }
    }
  }

  public function eval_function_call(\Guedel\AL\Expression\FunctionCall $fn)
  {
    $this->writer->out($fn->get_name() . '(');
    $first = true;
    foreach ($fn->get_parameters() as $parameter) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(', ');
      }
      $parameter->evaluate($this);
    }
    $this->writer->out(')');
  }

  public function eval_unary_expression(\Guedel\AL\Expression\UnaryExpression $exp)
  {
    $op = '';
    switch ($exp->getOperator()) {
      case \Guedel\AL\Expression\UnaryExpression::OP_ADD:
        $op = '';
        break;
      case \Guedel\AL\Expression\UnaryExpression::OP_SUB:
        $op = '-';
        break;
      case \Guedel\AL\Expression\UnaryExpression::OP_NOT:
        $op = $this->t('NOT') . ' ';
    }
    $this->writer->out($op);
    $exp->getOperand()->evaluate($this);
  }

  public function eval_value(\Guedel\AL\Expression\Value $value)
  {
    $v = $value->get_value();
    if (is_bool($v)) {
      $this->writer->out($v ? $this->t('TRUE') : $this->t('FALSE'));
    } elseif (is_string($v)) {
      $this->writer->out('"' . $v . '"');
    } else {
      $this->writer->out($v);
    }
  }

  public function eval_variable(\Guedel\AL\Expression\Variable $variable)
  {
    $this->writer->out($variable->get_varname());
  }

  public function visit_assign_stmt(\Guedel\AL\Statement\AssignStmt $stmt)
  {
    $this->writer->out($stmt->get_variable_name() . ' <- ');
    $stmt->get_expression()->evaluate($this);
    $this->writer->nl();
  }

  public function visit_for_each_stmt(\Guedel\AL\Statement\ForEachStmt $stmt)
  {
    $this->writer->out(sprintf('%s %s %s %s ', $this->t('FOR'), $this->t('EACH'), $stmt->getVarname(), $this->t('IN')));
    $stmt->getCollection()->evaluate($this);
    $this->writer->out(' ' . $this->t('DO'));
    $this->writer->nl();
    $this->writer->indent();
    $stmt->getStatement()->accept($this);
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'FOR'));
  }

  public function visit_for_stmt(\Guedel\AL\Statement\ForStmt $stmt)
  {
    $this->writer->out(sprintf('%s %s %s ', $this->t('FOR'), $stmt->getVariableName(), $this->t('FROM')));
    $stmt->getInitial()->evaluate($this);
    $this->writer->out(' ' . $this->t('TO') . ' ');
    $stmt->getFinal()->evaluate($this);
    $this->writer->out($this->ft(' %s ', $this->t('STEP')));
    $stmt->getIncrement()->evaluate($this);
    $this->writer->outln(' ' . $this->t('DO'));
    $this->writer->indent();
    $stmt->getStatement()->accept($this);
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'FOR'));
  }

  public function visit_if_then_stmt(\Guedel\AL\Statement\IfThenStmt $stmt)
  {
    $this->writer->out($this->t('IF') . ' ');
    $stmt->get_iftest()->evaluate($this);
    $this->writer->outln(' ' . $this->t('THEN'));
    $this->writer->indent();
    $stmt->get_then_part()->accept($this);
    $this->writer->unindent();
    if ($stmt->get_else_part() !== null) {
      $this->writer->outln($this->t('ELSE'));
      $this->writer->indent();
      $stmt->get_else_part()->accept($this);
      $this->writer->unindent();
    }
    $this->writer->outln($this->ft('%s %s', 'END', 'IF'));
  }

  public function visit_procedure_call(\Guedel\AL\Statement\ProcedureCall $proc)
  {
    $this->writer->out($proc->getName() . ' ');
    $first = true;
    foreach ($proc->getParameters() as $parameter) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(', ');
      }
      $parameter->evaluate($this);
    }
    $this->writer->nl();
  }

  public function visit_return_stmt(\Guedel\AL\Statement\ReturnStmt $stmt)
  {
    $this->writer->out($this->t('RETURN'));
    $list = $stmt->getExpressions();
    if (count($list) > 0) {
      $first = true;
      foreach ($list as $expr) {
        if ($first) {
          $first = false;
          $this->writer->out(' ');
        } else {
          $this->writer->out(', ');
        }
        $expr->evaluate($this);
      }
    }
    $this->writer->nl();
  }

  public function visit_statement_list(\Guedel\AL\Statement\StatementList $stmt)
  {
    foreach ($stmt->getIterator() as $stmt) {
      $stmt->accept($this);
    }
  }

  public function visit_while_stmt(\Guedel\AL\Statement\WhileStmt $stmt)
  {
    $this->writer->out($this->t('WHILE') . ' ');
    $stmt->get_test()->evaluate($this);
    $this->writer->outln(' ' . $this->t('DO'));
    $this->writer->indent();
    $stmt->get_statement()->accept($this);
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'WHILE'));
  }

  public function visit_comment(\Guedel\AL\Statement\Comment $stmt)
  {
    $lines = $stmt->getMessage();
    if (is_array($lines)) {
      $this->writer->out("/* ");
      foreach ($lines as $line) {
        $this->writer->out(" * ");
        $this->writer->outln($line);
      }
      $this->writer->outln(" */");
    } else {
      $this->writer->out("// ");
      $this->writer->outln($lines);
    }
  }

  public function visit_any(\Guedel\AL\Datatype\Any $type)
  {
    $this->writer->out($this->t('ANY'));
  }

  public function visit_arrayof(\Guedel\AL\Datatype\ArrayOf $type)
  {
    $this->writer->out($this->t('ARRAY'));
    $lowerbound = $type->getLowerbound();
    $upperbound = $type->getUpperbound();

    if ($lowerbound !== null || $upperbound !== null) {
      $this->writer->out(' [');
      if ($lowerbound !== null) {
        $this->writer->out($lowerbound);
      }
      $this->writer->out(', ');
      if ($upperbound !== null) {
        $this->writer->out($upperbound);
      }
      $this->writer->out(']');
    }

    if ($type->getType() !== null) {
      $this->writer->out(' ' . $this->t('OF') . ' ');
      $type->getType()->accept($this);
    }
  }

  public function visit_enumeration(\Guedel\AL\Datatype\Enumeration $type)
  {
    $this->writer->out('{');
    $first = true;
    foreach ($type->get_symbols() as $symbol) {
      if ($first) {
        $first = false;
      } else {
        $this->writer->out(', ');
      }
      $this->writer->out($symbol);
    }
  }

  public function visit_reference(\Guedel\AL\Datatype\Reference $type)
  {
    $this->writer->out($this->ft('%s %s ', 'REF', 'OF'));
    $type->get_type()->accept($this);
  }

  public function visit_string(\Guedel\AL\Datatype\StringOfChars $type)
  {
    $len = $type->get_length();
    $this->writer->out($this->t('STRING'));
    if ($len !== null) {
      $this->writer->out(' * ' . $len);
    }
  }

  public function visit_structure(\Guedel\AL\Datatype\Structure $type)
  {
    $this->writer->outln($this->t('STRUCT'));
    $this->writer->indent();
    foreach ($type->get_attributes() as $attribute) {
      $attribute->accept($this);
    }
    $this->writer->unindent();
    $this->writer->outln($this->ft('%s %s', 'END', 'STRUCT'));
  }

  public function visit_typename(\Guedel\AL\Datatype\TypeName $type)
  {
    $this->writer->out($type->get_name());
  }

  public function visit_number(\Guedel\AL\Datatype\Number $type)
  {
    $this->writer->out($this->t('NUMBER') . '(' . $type->getLength() . ', ' . $type->getPrecision() . ')');
  }

  public function visit_class(\Guedel\AL\Datatype\ClassType $type)
  {
    $this->writer
        ->outln($this->t('CLASS'))
        ->indent()
    ;
    foreach ($type->get_attributes() as $attribute) {
      $attribute->accept($this);
    }
    $this->writer
        ->unindent()
        ->outln($this->ft('%s %s', 'END', 'CLASS'));
  }

  /**
   * Translate language's tokens
   * @param string $token
   * @return string
   */
  private function t(string $token): string
  {
    if ($this->translator !== null) {
      return $this->translator->_t($token);
    }
    return $token;
  }

  private function ft(string $format, ...$args)
  {
    $tr = [];
    foreach ($args as $arg) {
      $tr[] = $this->t($arg);
    }
    return sprintf($format, ... $tr);
  }

}
