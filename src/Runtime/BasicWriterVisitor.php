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

use Guedel\Stream\CodeWriter;
use Guedel\AL\Runtime\Translator;
use Guedel\AL\Datatype\TypeName;

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

  public function declareFunction(\Guedel\AL\Declaration\FunctionDecl $decl)
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

      $decl->getReturnType()->accept($this);
      $this->writer->nl();
      $this->writer->indent();

      $decl->getBody()->accept($this);
      $this->writer->unindent();
      $this->writer->outln($this->t('END') . ' ' . $this->t('FUNCTION'));
  }

  public function declareModule(\Guedel\AL\Declaration\Module $decl)
  {
      $this->writer->outln($this->t('MODULE') . ' ' . $decl->getName());
      $this->writer->indent();
    foreach ($decl->getStatements() as $statement) {
        $statement->accept($this);
    }
      $this->writer->unindent();
      $this->writer->outln($this->ft('%s %s', 'END', 'MODULE'));
  }

  public function declareParameter(\Guedel\AL\Declaration\Parameter $decl)
  {
      $this->writer->out($decl->getDirection() . ' ');
      $this->writer->out($decl->getName());
      $this->writer->out(': ');
      $decl->getType()->accept($this);
  }

  public function declareProcedure(\Guedel\AL\Declaration\ProcedureDecl $decl)
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

  public function declareType(\Guedel\AL\Declaration\TypeDecl $decl)
  {
      $this->writer->out($this->t('TYPE') . ' ' . $decl->getName());
      $this->writer->out(': ');
      $decl->getDefinition()->accept($this);
      $this->writer->nl();
  }

  public function declareVariable(\Guedel\AL\Declaration\VariableDecl $decl)
  {
      $this->writer->out($this->t('VAR') . ' ' . $decl->getName());
      $this->writer->out(': ');
      $decl->getType()->accept($this);
      $this->writer->nl();
  }

  public function evalBinaryExpression(\Guedel\AL\Expression\BinaryExpression $exp)
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

  public function evalFunctionCall(\Guedel\AL\Expression\FunctionCall $fn)
  {
      $this->writer->out($fn->getName() . '(');
      $first = true;
    foreach ($fn->getParameters() as $parameter) {
      if ($first) {
        $first = false;
      } else {
          $this->writer->out(', ');
      }
        $parameter->evaluate($this);
    }
      $this->writer->out(')');
  }

  public function evalUnaryExpression(\Guedel\AL\Expression\UnaryExpression $exp)
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

  public function evalValue(\Guedel\AL\Expression\Value $value)
  {
      $v = $value->getValue();
    if (is_bool($v)) {
        $this->writer->out($v ? $this->t('TRUE') : $this->t('FALSE'));
    } elseif (is_string($v)) {
        $this->writer->out('"' . $v . '"');
    } else {
        $this->writer->out($v);
    }
  }

  public function evalVariable(\Guedel\AL\Expression\Variable $variable)
  {
      $this->writer->out($variable->getVarname());
  }

  public function visitAssignStmt(\Guedel\AL\Statement\AssignStmt $stmt)
  {
      $this->writer->out($stmt->getVariableName() . ' <- ');
      $stmt->getExpression()->evaluate($this);
      $this->writer->nl();
  }

  public function visitForEachStmt(\Guedel\AL\Statement\ForEachStmt $stmt)
  {
      $this->writer->out(sprintf(
          '%s %s %s %s ',
          $this->t('FOR'),
          $this->t('EACH'),
          $stmt->getVarname(),
          $this->t('IN')
      ));
      $stmt->getCollection()->evaluate($this);
      $this->writer->out(' ' . $this->t('DO'));
      $this->writer->nl();
      $this->writer->indent();
      $stmt->getStatement()->accept($this);
      $this->writer->unindent();
      $this->writer->outln($this->ft('%s %s', 'END', 'FOR'));
  }

  public function visitForStmt(\Guedel\AL\Statement\ForStmt $stmt)
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

  public function visitIfThenStmt(\Guedel\AL\Statement\IfThenStmt $stmt)
  {
      $this->writer->out($this->t('IF') . ' ');
      $stmt->getIfTest()->evaluate($this);
      $this->writer->outln(' ' . $this->t('THEN'));
      $this->writer->indent();
      $stmt->getThenPart()->accept($this);
      $this->writer->unindent();
    if ($stmt->getElsePart() !== null) {
        $this->writer->outln($this->t('ELSE'));
        $this->writer->indent();
        $stmt->getElsePart()->accept($this);
        $this->writer->unindent();
    }
      $this->writer->outln($this->ft('%s %s', 'END', 'IF'));
  }

  public function visitProcedureCall(\Guedel\AL\Statement\ProcedureCall $proc)
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

  public function visitReturnStmt(\Guedel\AL\Statement\ReturnStmt $stmt)
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

  public function visitStatementList(\Guedel\AL\Statement\StatementList $stmt)
  {
    foreach ($stmt->getIterator() as $stmt) {
        $stmt->accept($this);
    }
  }

  public function visitWhileStmt(\Guedel\AL\Statement\WhileStmt $stmt)
  {
      $this->writer->out($this->t('WHILE') . ' ');
      $stmt->getTest()->evaluate($this);
      $this->writer->outln(' ' . $this->t('DO'));
      $this->writer->indent();
      $stmt->getStatement()->accept($this);
      $this->writer->unindent();
      $this->writer->outln($this->ft('%s %s', 'END', 'WHILE'));
  }

  public function visitComment(\Guedel\AL\Statement\Comment $stmt)
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

  public function visitAny(\Guedel\AL\Datatype\Any $type)
  {
      $this->writer->out($this->t('ANY'));
  }

  public function visitArrayof(\Guedel\AL\Datatype\ArrayOf $type)
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

  public function visitEnumeration(\Guedel\AL\Datatype\Enumeration $type)
  {
      $this->writer->out('{');
      $first = true;
    foreach ($type->getSymbols() as $symbol) {
      if ($first) {
        $first = false;
      } else {
          $this->writer->out(', ');
      }
        $this->writer->out($symbol);
    }
      $this->writer->out("}");
  }

  public function visitReference(\Guedel\AL\Datatype\Reference $type)
  {
      $this->writer->out($this->ft('%s %s ', 'REF', 'OF'));
      $type->getType()->accept($this);
  }

  public function visitString(\Guedel\AL\Datatype\StringOfChars $type)
  {
      $len = $type->getLength();
      $this->writer->out($this->t('STRING'));
    if ($len !== null) {
        $this->writer->out(' * ' . $len);
    }
  }

  public function visitStructure(\Guedel\AL\Datatype\Structure $type)
  {
      $this->writer->outln($this->t('STRUCT'));
      $this->writer->indent();
    foreach ($type->getAttributes() as $attribute) {
        $attribute->accept($this);
    }
      $this->writer->unindent();
      $this->writer->out($this->ft('%s %s', 'END', 'STRUCT'));
  }

  public function visitTypename(\Guedel\AL\Datatype\TypeName $type)
  {
      $name = $type->getName();
    switch ($name) {
      case TypeName::DT_INTEGER:
        $outputname = $this->t("INTEGER");
            break;
      case TypeName::DT_FLOAT:
          $outputname = $this->t("FLOAT");
            break;
      case TypeName::DT_ANY:
          $outputname = $this->t("ANY");
            break;
      default:
          $outputname = $this->t($name);
            break;
    }
      $this->writer->out($outputname);
  }

  public function visitNumber(\Guedel\AL\Datatype\Number $type)
  {
      $size = '';
    if ($type->getLength() !== null) {
        $size .= $type->getLength();
    }
    if ($type->getPrecision() !== null) {
        $size .= ', ' . $type->getPrecision();
    }
      $this->writer->out($this->t('NUMBER'));
    if (0 < strlen($size)) {
        $this->writer->out('(' . $size . ')');
    }
  }

  public function visitClass(\Guedel\AL\Datatype\ClassType $type)
  {
      $this->writer
      ->outln($this->t('CLASS'))
      ->indent()
      ;
    foreach ($type->getAttributes() as $attribute) {
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
        return $this->translator->tr($token);
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
