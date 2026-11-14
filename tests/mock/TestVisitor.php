<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Mock\AL;

use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Declaration\Module;
use Guedel\AL\Declaration\Parameter;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Expression\UnaryExpression;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Datatype\Any;
use Guedel\AL\Datatype\ArrayOf;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Datatype\ClassType;
use Guedel\AL\Datatype\Enumeration;
use Guedel\AL\Statement\ForEachStmt;
use Guedel\AL\Statement\ForStmt;
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Datatype\Number;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Datatype\Reference;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Datatype\StringOfChars;
use Guedel\AL\Datatype\Structure;
use Guedel\AL\Datatype\TypeName;
use Guedel\AL\Statement\WhileStmt;
use Guedel\AL\Statement\Comment;
use Guedel\AL\Runtime\Visitor;

/**
 * Mock for tests AL classes
 * @author Guedel <guedel87@live.fr>
 */
class TestVisitor implements Visitor
{
    //put your code here
    public function declareFunction(FunctionDecl $decl)
    {
    }

    public function declareModule(Module $decl)
    {
        return "MODULE " . $decl->getName();
    }

    public function declareParameter(Parameter $decl)
    {
    }

    public function declareProcedure(ProcedureDecl $decl)
    {
    }

    public function declareType(TypeDecl $decl)
    {
    }

    public function declareVariable(VariableDecl $decl)
    {
    }

    public function evalBinaryExpression(BinaryExpression $exp)
    {
        $operands = [];
        foreach ($exp->getOperands() as $op) {
            $operands[] = $op->evaluate($this);
        }
        return implode($exp->getOperator(), $operands);
    }

    public function evalFunctionCall(FunctionCall $fn)
    {
        switch ($fn->getName()) {
            case 'sin':
                return 0.5;
            case 'cos':
                return 0.66;
            case 'souschaine':
                return 'abc';
        }
    }

    public function evalUnaryExpression(UnaryExpression $exp)
    {
        return $exp->getOperator() . $exp->getOperand()->evaluate($this);
    }

    public function evalValue(Value $value)
    {
        return $value->getValue();
    }

    /**
     * Retourne une valeur différence selon la variable utilisée
     * @param Variable $variable
     * @return string
     */
    public function evalVariable(Variable $variable): string
    {
        return match ($variable->getVarname()) {
            'alpha' => 'abdef',
            'num' => '124',
            default => null,
        };
    }

    public function visitAny(Any $type)
    {
        return $type->getSignature();
    }

    public function visitArrayof(ArrayOf $type)
    {
        return $type->getSignature();
    }

    public function visitAssignStmt(AssignStmt $stmt)
    {
    }

    public function visitClass(ClassType $type)
    {
    }

    public function visitEnumeration(Enumeration $type)
    {
        return $type->getSignature();
    }

    public function visitForEachStmt(ForEachStmt $stmt)
    {
    }

    public function visitForStmt(ForStmt $stmt)
    {
    }

    public function visitIfThenStmt(IfThenStmt $stmt)
    {
    }

    public function visitNumber(Number $type)
    {
        return $type->getSignature();
    }

    public function visitProcedureCall(ProcedureCall $proc)
    {
    }

    public function visitReference(Reference $type)
    {
        return $type->getSignature();
    }

    public function visitReturnStmt(ReturnStmt $stmt)
    {
        $ct = count($stmt->getExpressions());
        if ($ct == 0) {
            return 'RETURN';
        } else {
            return "RETURN \"$ct expression\"";
        }
    }

    public function visitStatementList(StatementList $stmt)
    {
        return '// ' . $stmt->count() . ' statement(s)';
    }

    public function visitString(StringOfChars $type)
    {
        return $type->getSignature();
    }

    public function visitStructure(Structure $type)
    {
        return $type->getSignature();
    }

    public function visitTypename(TypeName $type)
    {
        return $type->getSignature();
    }

    public function visitWhileStmt(WhileStmt $stmt)
    {
        return 'WHILE ' . $stmt->getTest()->evaluate($this) . ' DO ' . $stmt->getStatement()->accept($this);
    }

    public function visitComment(Comment $stmt): string
    {
        return "// " . $stmt->getMessage();
    }
}
