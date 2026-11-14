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

use Guedel\AL\Statement\Statement;
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
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Statement\ForEachStmt;
use Guedel\AL\Statement\ForStmt;
use Guedel\AL\Statement\IfThenStmt;
use Guedel\AL\Statement\ProcedureCall;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Statement\WhileStmt;
use Guedel\AL\Statement\Comment;
use Guedel\AL\Datatype\Any;
use Guedel\AL\Datatype\ArrayOf;
use Guedel\AL\Datatype\Enumeration;
use Guedel\AL\Datatype\Reference;
use Guedel\AL\Datatype\StringOfChars;
use Guedel\AL\Datatype\Structure;
use Guedel\AL\Datatype\Number;
use Guedel\AL\Datatype\ClassType;
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
    private ?CodeWriter $writer;
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

    public function walk(Statement $grammar)
    {
        $grammar->accept($this);
    }

    public function declareFunction(FunctionDecl $decl)
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

    public function declareModule(Module $decl)
    {
        $this->writer->outln($this->t('MODULE') . ' ' . $decl->getName());
        $this->writer->indent();
        foreach ($decl->getStatements() as $statement) {
            $statement->accept($this);
        }
        $this->writer->unindent();
        $this->writer->outln($this->ft('%s %s', 'END', 'MODULE'));
    }

    public function declareParameter(Parameter $decl)
    {
        $this->writer->out($decl->getDirection() . ' ');
        $this->writer->out($decl->getName());
        $this->writer->out(': ');
        $decl->getType()->accept($this);
    }

    public function declareProcedure(ProcedureDecl $decl)
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

    public function declareType(TypeDecl $decl)
    {
        $this->writer->out($this->t('TYPE') . ' ' . $decl->getName());
        $this->writer->out(': ');
        $decl->getDefinition()->accept($this);
        $this->writer->nl();
    }

    public function declareVariable(VariableDecl $decl)
    {
        $this->writer->out($this->t('VAR') . ' ' . $decl->getName());
        $this->writer->out(': ');
        $decl->getType()->accept($this);
        $this->writer->nl();
    }

    public function evalBinaryExpression(BinaryExpression $exp)
    {
        $first = true;
        foreach ($exp->getOperands() as $op) {
            if ($first) {
                $first = false;
            } else {
                $this->writer->out(' ' . $exp->getOperator() . ' ');
            }
            $parenthesis = false;
            if ($op instanceof BinaryExpression) {
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

    public function evalFunctionCall(FunctionCall $fn)
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

    public function evalUnaryExpression(UnaryExpression $exp)
    {
        $op = '';
        switch ($exp->getOperator()) {
            case UnaryExpression::OP_ADD:
                $op = '';
                break;
            case UnaryExpression::OP_SUB:
                $op = '-';
                break;
            case UnaryExpression::OP_NOT:
                $op = $this->t('NOT') . ' ';
        }
        $this->writer->out($op);
        $exp->getOperand()->evaluate($this);
    }

    public function evalValue(Value $value)
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

    public function evalVariable(Variable $variable)
    {
        $this->writer->out($variable->getVarname());
    }

    public function visitAssignStmt(AssignStmt $stmt)
    {
        $this->writer->out($stmt->getVariableName() . ' <- ');
        $stmt->getExpression()->evaluate($this);
        $this->writer->nl();
    }

    public function visitForEachStmt(ForEachStmt $stmt)
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

    public function visitForStmt(ForStmt $stmt)
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

    public function visitIfThenStmt(IfThenStmt $stmt)
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

    public function visitProcedureCall(ProcedureCall $proc)
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

    public function visitReturnStmt(ReturnStmt $stmt)
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

    public function visitStatementList(StatementList $stmt)
    {
        foreach ($stmt->getIterator() as $stmt) {
            $stmt->accept($this);
        }
    }

    public function visitWhileStmt(WhileStmt $stmt)
    {
        $this->writer->out($this->t('WHILE') . ' ');
        $stmt->getTest()->evaluate($this);
        $this->writer->outln(' ' . $this->t('DO'));
        $this->writer->indent();
        $stmt->getStatement()->accept($this);
        $this->writer->unindent();
        $this->writer->outln($this->ft('%s %s', 'END', 'WHILE'));
    }

    public function visitComment(Comment $stmt)
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

    public function visitAny(Any $type)
    {
        $this->writer->out($this->t('ANY'));
    }

    public function visitArrayof(ArrayOf $type)
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

    public function visitEnumeration(Enumeration $type)
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

    public function visitReference(Reference $type)
    {
        $this->writer->out($this->ft('%s %s ', 'REF', 'OF'));
        $type->getType()->accept($this);
    }

    public function visitString(StringOfChars $type)
    {
        $len = $type->getLength();
        $this->writer->out($this->t('STRING'));
        if ($len !== null) {
            $this->writer->out(' * ' . $len);
        }
    }

    public function visitStructure(Structure $type)
    {
        $this->writer->outln($this->t('STRUCT'));
        $this->writer->indent();
        foreach ($type->getAttributes() as $attribute) {
            $attribute->accept($this);
        }
        $this->writer->unindent();
        $this->writer->out($this->ft('%s %s', 'END', 'STRUCT'));
    }

    public function visitTypename(TypeName $type)
    {
        $name = $type->getName();
        $outputname = match ($name) {
            TypeName::DT_INTEGER => $this->t("INTEGER"),
            TypeName::DT_FLOAT => $this->t("FLOAT"),
            TypeName::DT_ANY => $this->t("ANY"),
            default => $this->t($name),
        };
        $this->writer->out($outputname);
    }

    public function visitNumber(Number $type)
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

    public function visitClass(ClassType $type)
    {
        $this->writer->outln($this->t('CLASS'));
        $this->writer->indent();
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
