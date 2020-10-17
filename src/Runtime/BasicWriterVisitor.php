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

  namespace guedel\AL\Runtime;

  /**
   * Description of BasicWriterVisitor
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class BasicWriterVisitor implements Visitor
  {
    /**
     *
     * @var \Stream\CodeWriter
     */
    private $writer;
    private $translator;

    public function __construct(\guedel\Stream\CodeWriter $writer, \guedel\AL\Runtime\Translator $translator = null)
    {
      $this->writer = $writer;
      if ($translator === null) {
        $this->translator = new Translator();
      } else {
        $this->translator = $translator;
      }
    }

    public function walk(\guedel\AL\Statement\Statement $grammar)
    {
      $grammar->accept($this);
    }

    public function declare_function(\guedel\AL\Declaration\FunctionDecl $decl)
    {
      $this->writer->out('FONCTION ' . $decl->get_name() . '(');
      $first = true;
      foreach ($decl->get_parameters() as $parameter) {
        if ($first) {
          $first = false;
        } else {
          $this->writer->out(', ');
        }
        $parameter->accept($this);
      }
      $this->writer->out(' : ');

      $decl->get_returntype()->accept($this);
      $this->writer->nl();
      $this->writer->indent();

      $decl->get_body()->accept($this);
      $this->writer->unindent();
      $this->writer->writeln('FIN FONCTION');
      $this->writer->nl();
    }

    public function declare_module(\guedel\AL\Declaration\Module $decl)
    {
      $this->writer->outln('MODULE ' . $decl->get_name());
      $this->writer->indent();
      foreach($decl->get_statements() as $statement) {
        $statement->accept($this);
      }
      $this->writer->unindent();
      $this->writer->outln('FIN MODULE');
    }

    public function declare_parameter(\guedel\AL\Declaration\Parameter $decl)
    {
      $this->writer->out($decl->get_direction() . ' ');
      $this->writer->out($decl->get_name());
      $this->writer->out(': ' . $decl->get_type());
    }

    public function declare_procedure(\guedel\AL\Declaration\ProcedureDecl $decl)
    {
      $this->writer->out('PROCEDURE ' . $decl->get_name() . '(');
      $first = true;
      foreach ($decl->get_parameters() as $parameter) {
        if ($first) {
          $first = false;
        } else {
          $this->writer->out(', ');
        }
        $parameter->accept($this);
      }
      $this->writer->outln(' : ' . $decl->get_returntype());
      $this->writer->indent();

      $decl->get_body()->accept($this);
      $this->writer->unindent();
      $this->writer->outln('FIN PROCEDURE');
      $this->writer->nl();

    }

    public function declare_type(\guedel\AL\Declaration\TypeDecl $decl)
    {
      $this->writer->out('TYPE ' . $decl->get_name());
      $this->writer->out(': ');
      $decl->get_definition()->accept($this);
      $this->writer->nl();
    }

    public function declare_variable(\guedel\AL\Declaration\VariableDecl $decl)
    {
      $this->writer->out('VAR' . $decl->get_name());
      $this->writer->outln(': ' . $decl->get_type());
    }

    public function eval_binary_expression(\guedel\AL\Expression\BinaryExpression $exp)
    {

    }

    public function eval_function_call(\guedel\AL\Expression\FunctionCall $fn)
    {
      $this->writer->out($fn->get_name() . '(');
      $first = true;
      foreach($fn->get_parameters() as $parameter)
      {
        if ($first) {
          $first = false;
        } else {
          $this->writer->out(', ');
        }
        $parameter->evaluate($this);
      }
      $this->writer->out(')');
    }

    public function eval_unary_expression(\guedel\AL\Expression\UnaryExpression $exp)
    {
      $op = '';
      switch ($exp->get_operator())
      {
        case \guedel\AL\Expression\UnaryExpression::OP_ADD:
          $op = '';
          break;
        case \guedel\AL\Expression\UnaryExpression::OP_SUB:
          $op = '-';
          break;
        case \guedel\AL\Expression\UnaryExpression::OP_NOT:
          $op = 'NON ';
      }
      $this->writer->out($op);
      $exp->get_operand()->evaluate($this);
    }

    public function eval_value(\guedel\AL\Expression\Value $value)
    {
      $v = $value->get_value();
      if (is_bool($v)) {
        $this->writer->out($v ? 'VRAI' : 'FAUX');
      } elseif (is_string($v)) {
        $this->writer->out('"' . $v . '"');
      } else {
        $this->writer->out($v);
      }
    }

    public function eval_variable(\guedel\AL\Expression\Variable $variable)
    {
      $this->writer->out($variable->get_varname());
    }

    public function visit_assign_stmt(\guedel\AL\Statement\AssignStmt $stmt)
    {
      $this->writer->out($stmt->get_variable_name() . ' <- ' );
      $stmt->get_expression()->evaluate($this);
      $this->writer->nl;
    }

    public function visit_for_each_stmt(\guedel\AL\Statement\ForEachStmt $stmt)
    {
      $this->out('POUR ' . $stmt->get_varname() . ' DANS ');
      $stmt->get_collection()->evaluate($this);
      $this->writer->nl();
      $this->writer->indent();
      $stmt->get_statement()->accept($this);
      $this->writer->unindent();
      $this->writer->outln('FIN POUR');
    }

    public function visit_for_stmt(\guedel\AL\Statement\ForStmt $stmt)
    {
      $this->out('POUR ' . $stmt->get_varname() . ' DE ');
      $stmt->get_initial()->evaluate($this);
      $this->writer->out(' A ');
      $stmt->get_final()->evaluate($this);
      $this->writer->out(' PAS DE ');
      $stmt->get_increment()->evaluate($this);
      $this->writer->outln(' FAIRE');
      $this->writer->indent();
      $stmt->get_statement()->accept($this);
      $this->writer->unindent();
      $this->writer->outln('FIN POUR');
    }

    public function visit_if_then_stmt(\guedel\AL\Statement\IfThenStmt $stmt)
    {
      $this->writer->out('SI ');
      $stmt->get_iftest()->evaluate($this);
      $this->writer->outln(' ALORS');
      $this->writer->indent();
      $stmt->get_then_part()->accept($this);
      $this->writer->unindent();
      if ($stmt->get_else_part() !== null) {
        $this->writer->outln('SINON');
        $this->writer->indent();
        $stmt->get_else_part()->accept($this);
        $this->writer->unindent();
      }
      $this->writer->outln('FIN SI');


    }

    public function visit_procedure_call(\guedel\AL\Statement\ProcedureCall $proc)
    {
      $this->writer->out($proc->get_name() . ' ');
      $first = true;
      foreach($proc->get_parameters() as $parameter)
      {
        if ($first) {
          $first = false;
        } else {
          $this->writer->out(', ');
        }
        $parameter->evaluate($this);
      }
      $this->writer->nl;
    }

    public function visit_return_stmt(\guedel\AL\Statement\ReturnStmt $stmt)
    {
      $this->writer->out('RETOURNE');
      $list = $stmt->get_expressions();
      if (count($list->get_items()) > 0) {
        $first = true;
        foreach($list->getIterator() as $expr) {
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

    public function visit_statement_list(\guedel\AL\Statement\StatementList $stmt)
    {
      foreach($stmt->getIterator() as $stmt) {
        $stmt->accept($this);
      }
    }

    public function visit_while_stmt(\guedel\AL\Statement\WhileStmt $stmt)
    {
      $this->writer->out('TANT QUE ');
      $stmt->get_test()->evaluate($this);
      $this->writer->outln(' FAIRE');
      $this->writer->indent();
      $stmt->get_statement()->accept($this);
      $this->writer->unindent();
      $this->writer->outln('FIN TANT QUE');
    }

    public function visit_any(\guedel\AL\Datatype\Any $type)
    {
      $this->writer->out('QUELCONQUE');
    }

    public function visit_arrayof(\guedel\AL\Datatype\ArrayOf $type)
    {
      $this->writer->out('TABLEAU');
      $lowerbound = $type->get_lowerbound();
      $upperbound = $type->get_upperbound();

      if ($lowerbound !== null || $upperbound !== null ) {
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

      if ($type->get_type() !== null) {
        $this->writer->out(' DE ');
        $type->get_type()->accept($this);
      }
    }

    public function visit_enumeration(\guedel\AL\Datatype\Enumeration $type)
    {
      $this->writer->out('{');
      $first = true;
      foreach($type->get_symbols() as $symbol)
      {
        if ($first) {
          $first = false;
        } else {
          $this->writer->out(', ');
        }
        $this->writer->out($symbol);
      }
    }

    public function visit_reference(\guedel\AL\Datatype\Reference $type)
    {
      $this->writer->out('REF DE ' );
      $type->get_type()->accept($this);
    }

    public function visit_string(\guedel\AL\Datatype\StringOfChars $type)
    {
      $len = $type->get_length();
      $this->writer->out('CHAINE');
      if ($len !== null) {
        $this->writer->out(' * ' . $len);
      }
    }

    public function visit_structure(\guedel\AL\Datatype\Structure $type)
    {
      $this->writer->outln('STRUCT');
      $this->writer->indent();
      foreach($type->get_attributes() as $attribute) {
        $attribute->accept($this);
      }
      $this->writer->unindent();
      $this->writer->outln('FIN STRUCT');
    }

    public function visit_typename(\guedel\AL\Datatype\TypeName $type)
    {
      $this->writer->out($type->get_name());
    }

    public function visit_number(\guedel\AL\Datatype\Number $type)
    {
      $this->writer->out('NOMBRE('. $type->get_length() . ', ' . $type->get_precision());
    }

    public function visit_class(\guedel\AL\Datatype\ClassType $type)
    {
      $this->writer
          ->outln('CLASSE')
          ->indent()
      ;
      foreach($type->get_attributes() as $attribute) {
        $attribute->accept($this);
      }
      $this->writer
          ->unindent()
          ->outln('FIN CLASSE');
    }

  }
