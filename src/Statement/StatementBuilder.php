<?php

namespace Guedel\AL\Statement;

class StatementBuilder extends Builder
{
    public function stmtVariable(string $name, Datatype\Type $type): Builder
    {
        $this->statements->add(new Declaration\VariableDecl($name, $type));
        return $this;
    }

    public function let(string $varname, Expression\Valuable $value): Builder
    {
        $this->statements->add(new AssignStmt($varname, $value));
        return $this;
    }

    public function stmtFor($varname, $init, $final, $step): Builder
    {
        $ret = $this->stmtBegin();
        $this->statements->add(
            new ForStmt(
                $varname,
                $init,
                $final,
                $step,
                $ret->statements,
            ),
        );
        return $ret;
    }

    public function stmtForEach($varname, $collection): Builder
    {
        $ret = $this->stmtBegin();
        $this->statements->add(
            new ForEachStmt($varname, $collection, $ret->statements),
        );
        return $ret;
    }

    public function stmtIf($test): Builder
    {
        $then = $this->stmtBegin();
        $else = new StatementList();

        $this->statements->add(
            new IfThenStmt($test, $then->statements, $else),
        );
        return $then;
    }

    public function stmtElse(): Builder
    {
        $me = $this->stmtEnd();
        $ret = $me->stmtBegin();
        $last = $me->statements->last();
        if ($last instanceof IfThenStmt) {
            $ret->statements->add($last->getElsePart());
        }
        return $ret;
    }

    public function stmtWhile(Expression\Valuable $test): Builder
    {
        $ret = $this->stmtBegin();
        $this->statements->add(
            new WhileStmt($test, $ret->statements),
        );
        return $ret;
    }

    public function stmtCall(string $name, ...$args): Builder
    {
        $a = [];
        foreach ($args as $arg) {
            if ($arg instanceof Expression\Valuable) {
                $a[] = $arg;
            } else {
                $a[] = new Expression\Value($arg);
            }
        }
        $this->statements->add(new ProcedureCall($name, ...$a));
        return $this;
    }
}
