<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Runtime;

use Guedel\AL\Declaration\Module;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Declaration\Parameter;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\AL\Statement\ForStmt;
use Guedel\AL\Statement\ForEachStmt;
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Statement\WhileStmt;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Statement\Comment;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\UnaryExpression;
use Guedel\AL\Datatype\StringOfChars;
use Guedel\AL\Datatype\Any;
use Guedel\AL\Datatype\TypeName;
use Guedel\AL\Datatype\ArrayOf;
use Guedel\AL\Datatype\Structure;
use Guedel\AL\Datatype\ClassType;
use Guedel\AL\Datatype\Reference;
use Guedel\AL\Datatype\Enumeration;
use Guedel\AL\Datatype\Number;

/**
 * Description of Visitor
 *
 * @author Guedel <guedel87@live.fr>
 */
interface Visitor
{
    // Declarations
    public function declareModule(Module $decl);
    public function declareVariable(VariableDecl $decl);
    public function declareFunction(FunctionDecl $decl);
    public function declareProcedure(ProcedureDecl $decl);
    public function declareType(TypeDecl $decl);
    public function declareParameter(Parameter $decl);

    // Statements
    public function visitAssignStmt(AssignStmt $stmt);
    public function visitReturnStmt(ReturnStmt $stmt);
    public function visitForStmt(ForStmt $stmt);
    public function visitForEachStmt(ForEachStmt $stmt);
    public function visitIfThenStmt(IfThenStmt $stmt);
    public function visitWhileStmt(WhileStmt $stmt);
    public function visitProcedureCall(ProcedureCall $proc);
    public function visitStatementList(StatementList $stmt);
    public function visitComment(Comment $stmt);

    // Expressions
    public function evalValue(Value $value);
    public function evalVariable(Variable $variable);
    public function evalFunctionCall(FunctionCall $fn);
    public function evalBinaryExpression(BinaryExpression $exp);
    public function evalUnaryExpression(UnaryExpression $exp);

    // Type definition
    public function visitString(StringOfChars $type);
    public function visitAny(Any $type);
    public function visitTypename(TypeName $type);
    public function visitArrayof(ArrayOf $type);
    public function visitStructure(Structure $type);
    public function visitClass(ClassType $type);
    public function visitReference(Reference $type);
    public function visitEnumeration(Enumeration $type);
    public function visitNumber(Number $type);
}
