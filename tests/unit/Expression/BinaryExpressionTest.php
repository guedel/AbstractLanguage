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
use Guedel\Tests\Mock\AL\TestVisitor;
use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Expression\Value;
use Guedel\AL\Expression\BinaryExpression;

/**
 * Description of BinaryExpressionTests
 *
 * @author Guedel <guedel87@live.fr>
 * @covers \Guedel\AL\Expression\BinaryExpression
 */
#[CoversClass(BinaryExpression::class)]
#[UsesClass(Expression::class)]
#[UsesClass(ExpressionList::class)]
#[UsesClass(Value::class)]
class BinaryExpressionTest extends TestCase
{
    public function testBinary()
    {
        $e = new BinaryExpression(Expression::OP_ADD, new Value(1), new Value(2));
        $this->assertEquals("1+2", $e->evaluate(new TestVisitor()));
    }
}
