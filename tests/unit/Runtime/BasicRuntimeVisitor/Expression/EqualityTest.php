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
 * Description of EqualityTests
 *
 * @author Guedel <guedel87@live.fr>
 * @covers \Guedel\AL\Expression\Expression
 * @covers \Guedel\AL\Expression\ExpressionList
 * @covers \Guedel\AL\Expression\Value
 * @covers \Guedel\AL\Expression\BinaryExpression
 * @covers \Guedel\AL\Runtime\BasicRuntimeVisitor
 */
class EqualityTest extends TestCase
{
    private $visitor;

    public function setUp(): void
    {
        $this->visitor = new BasicRuntimeVisitor();
    }

    /**
     * @dataProvider equalityExpressions
     */
    public function testIsEqual(int $expect, BinaryExpression $exp): void
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    /**
     * @dataProvider differentExpressions
     */
    public function testIsDifferent(int $expect, BinaryExpression $exp): void
    {
        $res = $exp->evaluate($this->visitor);
        $this->assertEquals($expect, $res);
    }

    public static function equalityExpressions()
    {
        return [
        1 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2))],
        2 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(3))],
        3 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2), new Value(2))],
        4 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(2), new Value(2), new Value(3))],
        5 => [1, new BinaryExpression(Expression::OP_EQUAL, new Value(0), new Value(0), new Value(0))],
        6 => [0, new BinaryExpression(Expression::OP_EQUAL, new Value(0), new Value(0), new Value(1))],
        ];
    }

    public static function differentExpressions()
    {
        return [
        1 => [0, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(2))],
        2 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3))],
        3 => [0, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(2), new Value(2))],
        4 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3), new Value(4))],
        5 => [1, new BinaryExpression(Expression::OP_DIFF, new Value(2), new Value(3), new Value(2))],
        ];
    }
}
