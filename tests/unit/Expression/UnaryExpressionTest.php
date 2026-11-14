<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\Expression;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\UnaryExpression;
use Guedel\Tests\Mock\AL\TestVisitor;
use Guedel\AL\Expression\Value;

/**
 * Description of UnaryExpressionTest
 *
 * @author Guedel <guedel87@live.fr>
 */
#[CoversClass(UnaryExpression::class)]
#[UsesClass(Expression::class)]
#[UsesClass(Value::class)]
class UnaryExpressionTest extends TestCase
{
    public function testConstruct()
    {
        $e = new UnaryExpression(Expression::OP_ADD, new Value('0'));
        $this->assertEquals(Expression::OP_ADD, $e->getOperator());
        $this->assertEquals('0', $e->getOperand()->getValue());
    }

    public function testAccept()
    {
        $e = new UnaryExpression(Expression::OP_SUB, new Value('1'));
        $this->assertEquals('-1', $e->evaluate(new TestVisitor()));
    }
}
