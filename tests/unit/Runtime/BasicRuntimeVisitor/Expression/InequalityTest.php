<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\AL\Runtime\BasicRuntimeVisitor\Expression;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\BasicRuntimeVisitor;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\BinaryExpression;
use Guedel\AL\Expression\Value;

/**
 * Description of InequalityTest
 *
 * @covers \Guedel\AL\Expression\Expression
 * @covers \Guedel\AL\Expression\ExpressionList
 * @covers \Guedel\AL\Expression\Value
 * @covers \Guedel\AL\Expression\BinaryExpression
 * @covers \Guedel\AL\Runtime\BasicRuntimeVisitor
 * @author Guedel <guedel87@live.fr>
 */
class InequalityTest extends TestCase
{
    private $visitor;

    public function setUp(): void
    {
        $this->visitor = new BasicRuntimeVisitor();
    }

    /**
     * @dataProvider lessThanExpressions
     */
    public function testIsLessThan($expect, BinaryExpression $exp)
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    /**
     * @dataProvider lessThanOrEqualExpressions
     * @param type $expect
     * @param BinaryExpression $exp
     */
    public function testIsLessThanOrEqual($expect, BinaryExpression $exp)
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    /**
     * @dataProvider greatThanExpression
     * @param type $expect
     * @param BinaryExpression $exp
     */
    public function testIsGreatThan($expect, BinaryExpression $exp)
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    /**
     * @dataProvider greatThanOrEqualExpression
     * @param type $expect
     * @param BinaryExpression $exp
     */
    public function testIsGreatThanOrEqual($expect, BinaryExpression $exp)
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    public static function lessThanExpressions()
    {
        return [
        1 => [1, new BinaryExpression(Expression::OP_LT, new Value(1), new Value(2))],
        2 => [0 , new BinaryExpression(Expression::OP_LT, new Value(2), new Value(1))],
        3 => [0 , new BinaryExpression(Expression::OP_LT, new Value(2), new Value(2))],
        4 => [1 , new BinaryExpression(Expression::OP_LT, new Value(-4), new Value(-3))],
        5 => [1 , new BinaryExpression(Expression::OP_LT, new Value(2), new Value(3), new Value(4))],
        5 => [0 , new BinaryExpression(Expression::OP_LT, new Value(2), new Value(3), new Value(2))],
        ];
    }

    public static function lessThanOrEqualExpressions()
    {
        return [
        1 => [1, new BinaryExpression(Expression::OP_LTE, new Value(1), new Value(2))],
        2 => [0 , new BinaryExpression(Expression::OP_LTE, new Value(2), new Value(1))],
        3 => [1 , new BinaryExpression(Expression::OP_LTE, new Value(2), new Value(2))],
        4 => [1 , new BinaryExpression(Expression::OP_LTE, new Value(-4), new Value(-3))],
        5 => [1 , new BinaryExpression(Expression::OP_LTE, new Value(2), new Value(3), new Value(4))],
        5 => [0 , new BinaryExpression(Expression::OP_LTE, new Value(2), new Value(3), new Value(2))],
        6 => [1 , new BinaryExpression(Expression::OP_LTE, new Value(2), new Value(3), new Value(3))],
        ];
    }

    public static function greatThanExpression()
    {
        return [
        1 => [0, new BinaryExpression(Expression::OP_GT, new Value(1), new Value(2))],
        2 => [1 , new BinaryExpression(Expression::OP_GT, new Value(2), new Value(1))],
        3 => [0 , new BinaryExpression(Expression::OP_GT, new Value(2), new Value(2))],
        4 => [1 , new BinaryExpression(Expression::OP_GT, new Value(-3), new Value(-4))],
        5 => [1 , new BinaryExpression(Expression::OP_GT, new Value(4), new Value(3), new Value(2))],
        5 => [0 , new BinaryExpression(Expression::OP_GT, new Value(3), new Value(2), new Value(2))],
        ];
    }

    public static function greatThanOrEqualExpression()
    {
        return [
         1 => [0, new BinaryExpression(Expression::OP_GTE, new Value(1), new Value(2))],
         2 => [1 , new BinaryExpression(Expression::OP_GTE, new Value(2), new Value(1))],
         3 => [1 , new BinaryExpression(Expression::OP_GTE, new Value(2), new Value(2))],
         4 => [1 , new BinaryExpression(Expression::OP_GTE, new Value(-3), new Value(-4))],
         5 => [1 , new BinaryExpression(Expression::OP_GTE, new Value(4), new Value(3), new Value(2))],
         5 => [1 , new BinaryExpression(Expression::OP_GTE, new Value(3), new Value(2), new Value(2))],
        ];
    }
}
