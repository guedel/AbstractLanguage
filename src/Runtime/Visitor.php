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
  public function declareModule(\Guedel\AL\Declaration\Module $decl);
  public function declareVariable(\Guedel\AL\Declaration\VariableDecl $decl);
  public function declareFunction(\Guedel\AL\Declaration\FunctionDecl $decl);
  public function declareProcedure(\Guedel\AL\Declaration\ProcedureDecl $decl);
  public function declareType(\Guedel\AL\Declaration\TypeDecl $decl);
  public function declareParameter(\Guedel\AL\Declaration\Parameter $decl);

    // Statements
  public function visitAssignStmt(\Guedel\AL\Statement\AssignStmt $stmt);
  public function visitReturnStmt(\Guedel\AL\Statement\ReturnStmt $stmt);
  public function visitForStmt(\Guedel\AL\Statement\ForStmt $stmt);
  public function visitForEachStmt(\Guedel\AL\Statement\ForEachStmt $stmt);
  public function visitIfThenStmt(\Guedel\AL\Statement\IfThenStmt $stmt);
  public function visitWhileStmt(\Guedel\AL\Statement\WhileStmt $stmt);
  public function visitProcedureCall(\Guedel\AL\Statement\ProcedureCall $proc);
  public function visitStatementList(\Guedel\AL\Statement\StatementList $stmt);
  public function visitComment(\Guedel\AL\Statement\Comment $stmt);

    // Expressions
  public function evalValue(\Guedel\AL\Expression\Value $value);
  public function evalVariable(\Guedel\AL\Expression\Variable $variable);
  public function evalFunctionCall(\Guedel\AL\Expression\FunctionCall $fn);
  public function evalBinaryExpression(\Guedel\AL\Expression\BinaryExpression $exp);
  public function evalUnaryExpression(\Guedel\AL\Expression\UnaryExpression $exp);

    // Type definition
  public function visitString(\Guedel\AL\Datatype\StringOfChars $type);
  public function visitAny(\Guedel\AL\Datatype\Any $type);
  public function visitTypename(\Guedel\AL\Datatype\TypeName $type);
  public function visitArrayof(\Guedel\AL\Datatype\ArrayOf $type);
  public function visitStructure(\Guedel\AL\Datatype\Structure $type);
  public function visitClass(\Guedel\AL\Datatype\ClassType $type);
  public function visitReference(\Guedel\AL\Datatype\Reference $type);
  public function visitEnumeration(\Guedel\AL\Datatype\Enumeration $type);
  public function visitNumber(\Guedel\AL\Datatype\Number $type);
}
