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

use Guedel\AL\Expression\Expression;
use Guedel\AL\Runtime\Visitor;

/**
 * Mock for tests AL classes
 * @author Guedel <guedel87@live.fr>
 */
class TestVisitor implements Visitor
{
    //put your code here
    public function declareFunction(\Guedel\AL\Declaration\FunctionDecl $decl)
    {
    }

    public function declareModule(\Guedel\AL\Declaration\Module $decl)
    {
        return "MODULE " . $decl->getName();
    }

    public function declareParameter(\Guedel\AL\Declaration\Parameter $decl)
    {
    }

    public function declareProcedure(\Guedel\AL\Declaration\ProcedureDecl $decl)
    {
    }

    public function declareType(\Guedel\AL\Declaration\TypeDecl $decl)
    {
    }

    public function declareVariable(\Guedel\AL\Declaration\VariableDecl $decl)
    {
    }

    public function evalBinaryExpression(\Guedel\AL\Expression\BinaryExpression $exp)
    {
        $operands = [];
        foreach ($exp->getOperands() as $op) {
            $operands[] = $op->evaluate($this);
        }
        return join($exp->getOperator(), $operands);
    }

    public function evalFunctionCall(\Guedel\AL\Expression\FunctionCall $fn)
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

    public function evalUnaryExpression(\Guedel\AL\Expression\UnaryExpression $exp)
    {
        return $exp->getOperator() . $exp->getOperand()->evaluate($this);
    }

    public function evalValue(\Guedel\AL\Expression\Value $value)
    {
        return $value->getValue();
    }

    /**
     * Retourne une valeur différence selon la variable utilisée
     * @param \Guedel\AL\Expression\Variable $variable
     * @return string
     */
    public function evalVariable(\Guedel\AL\Expression\Variable $variable): string
    {
        switch ($variable->getVarname()) {
            case 'alpha':
                return 'abdef';
            case 'num':
                return '124';
        }
        return null;
    }

    public function visitAny(\Guedel\AL\Datatype\Any $type)
    {
        return $type->getSignature();
    }

    public function visitArrayof(\Guedel\AL\Datatype\ArrayOf $type)
    {
        return $type->getSignature();
    }

    public function visitAssignStmt(\Guedel\AL\Statement\AssignStmt $stmt)
    {
    }

    public function visitClass(\Guedel\AL\Datatype\ClassType $type)
    {
    }

    public function visitEnumeration(\Guedel\AL\Datatype\Enumeration $type)
    {
        return $type->getSignature();
    }

    public function visitForEachStmt(\Guedel\AL\Statement\ForEachStmt $stmt)
    {
    }

    public function visitForStmt(\Guedel\AL\Statement\ForStmt $stmt)
    {
    }

    public function visitIfThenStmt(\Guedel\AL\Statement\IfThenStmt $stmt)
    {
    }

    public function visitNumber(\Guedel\AL\Datatype\Number $type)
    {
        return $type->getSignature();
    }

    public function visitProcedureCall(\Guedel\AL\Statement\ProcedureCall $proc)
    {
    }

    public function visitReference(\Guedel\AL\Datatype\Reference $type)
    {
        return $type->getSignature();
    }

    public function visitReturnStmt(\Guedel\AL\Statement\ReturnStmt $stmt)
    {
        $ct = count($stmt->getExpressions());
        if ($ct == 0) {
            return 'RETURN';
        } else {
            return "RETURN \"$ct expression\"";
        }
    }

    public function visitStatementList(\Guedel\AL\Statement\StatementList $stmt)
    {
        return '// ' . $stmt->count() . ' statement(s)';
    }

    public function visitString(\Guedel\AL\Datatype\StringOfChars $type)
    {
        return $type->getSignature();
    }

    public function visitStructure(\Guedel\AL\Datatype\Structure $type)
    {
        return $type->getSignature();
    }

    public function visitTypename(\Guedel\AL\Datatype\TypeName $type)
    {
        return $type->getSignature();
    }

    public function visitWhileStmt(\Guedel\AL\Statement\WhileStmt $stmt)
    {
        return 'WHILE ' . $stmt->getTest()->evaluate($this) . ' DO ' . $stmt->getStatement()->accept($this);
    }

    public function visitComment(\Guedel\AL\Statement\Comment $stmt): string
    {
        return "// " . $stmt->getMessage();
    }
}
