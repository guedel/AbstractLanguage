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

use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Declaration\Module;
use Guedel\AL\Declaration\Parameter;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Expression\FunctionCall;
use Guedel\AL\Expression\UnaryExpression;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\Variable;
use Guedel\AL\Datatype\Any;
use Guedel\AL\Datatype\ArrayOf;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Datatype\ClassType;
use Guedel\AL\Statement\Comment;
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
use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Statement\Statement;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\Valuable;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Exception\InvalidOperatorException;
use Guedel\AL\Exception\NotFoundException;
use Guedel\AL\Exception\EndlessLoopException;

/**
 * Description of BasicRuntimeVisitor
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicRuntimeVisitor implements Visitor
{
    private BasicRuntimeContext $context;

    private function debug($output)
    {
        $f = fopen("test.out", "a+");
        fwrite($f, $output . PHP_EOL);
        fclose($f);
    }

    public function run(Statement $statement)
    {
        $this->context = new BasicRuntimeContext();
        $statement->accept($this);
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
    public function declareFunction(FunctionDecl $decl)
    {
        $this->context->addFunction($decl);
    }

    public function declareModule(Module $decl)
    {
        $this->pushContext($decl->getName());
        foreach ($decl->getStatements() as $stmt) {
            $stmt->accept($this);
        }
        $this->popContext();
    }

    public function declareParameter(Parameter $decl)
    {
        $this->context->addVariable($decl);
    }

    public function declareProcedure(ProcedureDecl $decl)
    {
        $this->context->addProcedure($decl);
    }

    public function declareType(TypeDecl $decl)
    {
        $this->context->addType($decl);
    }

    public function declareVariable(VariableDecl $decl)
    {
        $this->context->addVariable($decl);
    }

    public function evalBinaryExpression(BinaryExpression $exp)
    {
        $first = true;
        $second = false;
        $acc = null;
        $prev = null;
        foreach ($exp->getOperands() as $operand) {
            $op = $operand->evaluate($this);
            if ($first) {
                $acc = $op;
                $first = false;
                $second = true;
                $prev = $op;
                continue;
            }
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
                    $acc = $second ? ($prev == $op) : ($acc && $prev == $op);
                    break;
                case Expression::OP_DIFF:
                    // a != b != c <=> a != b AND b != c
                    $acc = $second ? ($prev != $op) : ($acc && $prev != $op);
                    break;
                case Expression::OP_LT:
                    // a < b < c <=> a < b AND b < c
                    $acc = $second ? ($prev < $op) : ($acc && $prev < $op);
                    break;
                case Expression::OP_GT:
                    $acc = $second ? ($prev > $op) : ($acc && $prev > $op);
                    break;
                case Expression::OP_LTE:
                    $acc = ($second) ? ($prev <= $op) : ($acc && $prev <= $op);
                    break;
                case Expression::OP_GTE:
                    $acc = ($second) ? ($prev >= $op) : ($acc && $prev >= $op);
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
            $second = false;
            $prev = $op;
        }
        return $acc;
    }

    public function evalFunctionCall(FunctionCall $fn)
    {
        $name = strtolower($fn->getName());

        $func = $this->context->findFunction($name);
        if ($func === null) {
            if (function_exists($name)) {
                // call of PHP function
                return $this->phpFunction($fn);
            }
            throw new NotFoundException("function $name not found in this scope");
        }

        $this->pushContext($name);
        // Les arguments
        $itParams = $func->getParameters()->getIterator();
        foreach ($fn->getParameters() as $param) {
            if ($itParams->valid()) {
                $var = new VariableDecl($itParams->current()->getName(), $itParams->current()->getType());
                $var->setValue($param->getValue());
                $this->context->addVariable($var);
            }
            $itParams->next();
        }

        // Appel des instructions de la fonction
        $func->getBody()->accept($this);
        $return = [];
        if ($this->context->isReturnRequest()) {
            $return = $this->context->getReturnValues();
        }
        $this->popContext();
        return $return[0] ?? null;
    }

    public function evalUnaryExpression(UnaryExpression $exp)
    {
        return match ($exp->getOperator()) {
            Expression::OP_ADD => $exp->getOperand()->evaluate($this),
            Expression::OP_NOT => $exp->getOperand()->evaluate($this),
            Expression::OP_SUB => - $exp->getOperand()->evaluate($this),
            default => throw new InvalidOperatorException(),
        };
    }

    public function evalValue(Value $value)
    {
        return $value->getValue();
    }

    public function evalVariable(Variable $variable)
    {
        $name = $variable->getVarname();
        $v = $this->context->findVariable($name);
        if ($v === null) {
            throw new NotFoundException("variable $name not found in this scope");
        }
        return $v->getValue()->evaluate($this);
    }

    public function visitAny(Any $type)
    {
    }

    public function visitArrayof(ArrayOf $type)
    {
    }

    public function visitAssignStmt(AssignStmt $stmt)
    {
        $name = $stmt->getVariableName();
        $v = $this->context->findVariable($name);
        if ($v === null) {
            throw new NotFoundException("variable $name not found in this scope");
        }
        $value = $stmt->getExpression()->evaluate($this);
        $v->setValue($value);
    }

    public function visitClass(ClassType $type)
    {
        // TODO
    }

    public function visitComment(Comment $stmt)
    {
        // do nothing
    }

    public function visitEnumeration(Enumeration $type)
    {
    }

    public function visitForEachStmt(ForEachStmt $stmt)
    {
    }

    public function visitForStmt(ForStmt $stmt)
    {
        $name = $stmt->getVariableName();
        $var = $this->context->findVariable($name);
        if ($var === null) {
            // variable must be declared
            throw new NotFoundException("variable $name not found in this scope");
        }

        $start = $stmt->getInitial()->evaluate($this);
        $final = $stmt->getFinal()->evaluate($this);
        $increment = $stmt->getIncrement()->evaluate($this);
        if ($increment > 0) {
            for (
                $var->setValue($start);
                $var->getValue()->evaluate($this) <= $final;
                $var->setValue($var->getValue()->evaluate($this) + $increment)
            ) {
                $stmt->getStatement()->accept($this);
            }
            return;
        } elseif ($increment < 0) {
            for (
                $var->setValue($start);
                $var->getValue()->evaluate($this) >= $final;
                $var->setValue($var->getValue()->evaluate($this) + $increment)
            ) {
                $stmt->getStatement()->accept($this);
            }
            return;
        }
        throw new EndlessLoopException();
    }

    public function visitIfThenStmt(IfThenStmt $stmt)
    {
        $test = $stmt->getIfTest()->evaluate($this);
        if ($test) {
            return $stmt->getThenPart()->accept($this);
        }

        $elsePart = $stmt->getElsePart();
        if ($elsePart) {
            return $elsePart->accept($this);
        }
    }

    public function visitNumber(Number $type)
    {
    }

    public function visitProcedureCall(ProcedureCall $proc)
    {
        if ($this->internalCommand($proc)) {
            return;
        }
        $name = strtolower($proc->getName());
        $pf = $this->context->findProcedure($name);
        if ($pf === null) {
            if (function_exists($name)) {
                $this->phpProcedure($proc);
                return;
            }
            throw new NotFoundException("procedure $name not found in this scope");
        }

        $this->pushContext($name);
        // Les arguments
        $itParams = $pf->getParameters()->getIterator();
        foreach ($proc->getParameters() as $param) {
            if ($itParams->valid()) {
                // $this->debug(print_r($itParams, true));
                $var = new VariableDecl($itParams->current()->getName(), $itParams->current()->getType());
                $var->setValue($param->getValue());
                $this->context->addVariable($var);
            }
            $itParams->next();
        }

        // Appel des instructions de la fonction
        $pf->getBody()->accept($this);
        $this->popContext();
    }

    public function visitReference(Reference $type)
    {
    }

    /**
     * Return an array of values if multiple expressions
     * @param ReturnStmt $stmt
     */
    public function visitReturnStmt(ReturnStmt $stmt)
    {
        $value = [];
        foreach ($stmt->getExpressions() as $expr) {
            $value[] = $expr->evaluate($this);
        }
        $this->context->setEnableReturnRequest(...$value);
    }

    public function visitStatementList(StatementList $stmt)
    {
        foreach ($stmt as $s) {
            $s->accept($this);
            if ($this->context->isReturnRequest()) {
                return;
            }
        }
    }

    public function visitString(StringOfChars $type)
    {
    }

    public function visitStructure(Structure $type)
    {
    }

    public function visitTypename(TypeName $type)
    {
    }

    public function visitWhileStmt(WhileStmt $stmt)
    {
        $test = $stmt->getTest();
        while ($test->evaluate($this)) {
            $stmt->getStatement()->accept($this);
        }
    }

    /**
     *
     * @param ProcedureCall $proc
     * @return bool true if internal procédure found
     */
    private function internalCommand(ProcedureCall $proc): bool
    {
        // TODO remplacer par un mapping
        $name = strtolower($proc->getName());
        if ($name === 'write' || $name === 'writeln') {
            foreach ($proc->getParameters() as $p) {
                if ($p instanceof Valuable) {
                    echo $p->evaluate($this);
                }
            }
            if ($name === 'writeln') {
                echo PHP_EOL;
            }
            return true;
        }
        return false;
    }

    private function phpProcedure(ProcedureCall $proc): void
    {
        call_user_func_array($proc->getName(), $this->builParametersArray($proc->getParameters()));
    }

    private function phpFunction(FunctionCall $func)
    {
        return call_user_func_array($func->getName(), $this->builParametersArray($func->getParameters()));
    }

    private function builParametersArray(ExpressionList $list): array
    {
        $params = [];
        foreach ($list as $param) {
            if ($param instanceof Valuable) {
                $params[] = $param->evaluate($this);
            }
        }
        return $params;
    }
}
