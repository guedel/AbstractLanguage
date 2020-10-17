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

  use guedel\AL\Expression\Valuable;
  /**
   * Description of Visitor
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  interface Visitor
  {
    // Declarations
    public function declare_module(\guedel\AL\Declaration\Module $decl);
    public function declare_variable(\guedel\AL\Declaration\VariableDecl $decl);
    public function declare_function(\guedel\AL\Declaration\FunctionDecl $decl);
    public function declare_procedure(\guedel\AL\Declaration\ProcedureDecl $decl);
    public function declare_type(\guedel\AL\Declaration\TypeDecl $decl);
    public function declare_parameter(\guedel\AL\Declaration\Parameter $decl);

    // Statements
    public function visit_assign_stmt(\guedel\AL\Statement\AssignStmt $stmt);
    public function visit_return_stmt(\guedel\AL\Statement\ReturnStmt $stmt);
    public function visit_for_stmt(\guedel\AL\Statement\ForStmt $stmt);
    public function visit_for_each_stmt(\guedel\AL\Statement\ForEachStmt $stmt);
    public function visit_if_then_stmt(\guedel\AL\Statement\IfThenStmt $stmt);
    public function visit_while_stmt(\guedel\AL\Statement\WhileStmt $stmt);
    public function visit_procedure_call(\guedel\AL\Statement\ProcedureCall $proc);
    public function visit_statement_list(\guedel\AL\Statement\StatementList $stmt);

    // Expressions
    public function eval_value(\guedel\AL\Expression\Value $value);
    public function eval_variable(\guedel\AL\Expression\Variable $variable);
    public function eval_function_call(\guedel\AL\Expression\FunctionCall $fn);
    public function eval_binary_expression(\guedel\AL\Expression\BinaryExpression $exp);
    public function eval_unary_expression(\guedel\AL\Expression\UnaryExpression $exp);

    // Type definition
    public function visit_string(\guedel\AL\Datatype\StringOfChars $type);
    public function visit_any(\guedel\AL\Datatype\Any $type);
    public function visit_typename(\guedel\AL\Datatype\TypeName $type);
    public function visit_arrayof(\guedel\AL\Datatype\ArrayOf $type);
    public function visit_structure(\guedel\AL\Datatype\Structure $type);
    public function visit_class(\guedel\AL\Datatype\ClassType $type);
    public function visit_reference(\guedel\AL\Datatype\Reference $type);
    public function visit_enumeration(\guedel\AL\Datatype\Enumeration $type);
    public function visit_number(\guedel\AL\Datatype\Number $type);
  }
