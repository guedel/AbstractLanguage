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

  use Guedel\AL\Expression\Valuable;
  /**
   * Description of Visitor
   *
   * @author Guedel <guedel87@live.fr>
   */
  interface Visitor
  {
    // Declarations
    public function declare_module(\Guedel\AL\Declaration\Module $decl);
    public function declare_variable(\Guedel\AL\Declaration\VariableDecl $decl);
    public function declare_function(\Guedel\AL\Declaration\FunctionDecl $decl);
    public function declare_procedure(\Guedel\AL\Declaration\ProcedureDecl $decl);
    public function declare_type(\Guedel\AL\Declaration\TypeDecl $decl);
    public function declare_parameter(\Guedel\AL\Declaration\Parameter $decl);

    // Statements
    public function visit_assign_stmt(\Guedel\AL\Statement\AssignStmt $stmt);
    public function visit_return_stmt(\Guedel\AL\Statement\ReturnStmt $stmt);
    public function visit_for_stmt(\Guedel\AL\Statement\ForStmt $stmt);
    public function visit_for_each_stmt(\Guedel\AL\Statement\ForEachStmt $stmt);
    public function visit_if_then_stmt(\Guedel\AL\Statement\IfThenStmt $stmt);
    public function visit_while_stmt(\Guedel\AL\Statement\WhileStmt $stmt);
    public function visit_procedure_call(\Guedel\AL\Statement\ProcedureCall $proc);
    public function visit_statement_list(\Guedel\AL\Statement\StatementList $stmt);
    public function visit_comment(\Guedel\AL\Statement\Comment $stmt);

    // Expressions
    public function eval_value(\Guedel\AL\Expression\Value $value);
    public function eval_variable(\Guedel\AL\Expression\Variable $variable);
    public function eval_function_call(\Guedel\AL\Expression\FunctionCall $fn);
    public function eval_binary_expression(\Guedel\AL\Expression\BinaryExpression $exp);
    public function eval_unary_expression(\Guedel\AL\Expression\UnaryExpression $exp);

    // Type definition
    public function visit_string(\Guedel\AL\Datatype\StringOfChars $type);
    public function visit_any(\Guedel\AL\Datatype\Any $type);
    public function visit_typename(\Guedel\AL\Datatype\TypeName $type);
    public function visit_arrayof(\Guedel\AL\Datatype\ArrayOf $type);
    public function visit_structure(\Guedel\AL\Datatype\Structure $type);
    public function visit_class(\Guedel\AL\Datatype\ClassType $type);
    public function visit_reference(\Guedel\AL\Datatype\Reference $type);
    public function visit_enumeration(\Guedel\AL\Datatype\Enumeration $type);
    public function visit_number(\Guedel\AL\Datatype\Number $type);
  }
