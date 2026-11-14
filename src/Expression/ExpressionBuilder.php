<?php

namespace Guedel\AL\Expression;

trait ExpressionBuilder
{
    public function fnExp(string $name, Valuable ...$args): FunctionCall
    {
        return new FunctionCall($name, ... $args);
    }

    public function addExp(Valuable ...$exp): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_ADD, ... $exp);
    }

    public function subsExp(Valuable ...$exp): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_SUB, ... $exp);
    }

    public function multExp(Valuable ...$exp): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_MULT, ... $exp);
    }

    public function divExp(Valuable ...$exp): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_DIV, ... $exp);
    }

    public function eqExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_EQUAL, $left, $right);
    }

    public function ltExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_LT, $left, $right);
    }

    public function lteExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_LTE, $left, $right);
    }

    public function gtExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_GT, $left, $right);
    }

    public function gteExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_GTE, $left, $right);
    }

    public function diffExp(Valuable $left, Valuable $right): BinaryExpression
    {
        return new BinaryExpression(Expression::OP_DIFF, $left, $right);
    }

    public function v($val): Valuable
    {
        return new Value($val);
    }
}
