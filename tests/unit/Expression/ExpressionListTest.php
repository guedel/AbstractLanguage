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

use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\ExpressionList;
use Guedel\Tests\Mock\AL\EmptyExpression;

/**
 * Description of ExpressionListTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Expression\ExpressionList
 */
class ExpressionListTest extends TestCase
{
    public function testEmpty()
    {
        $list = new ExpressionList();
        $this->assertNotNull($list);
        $this->assertCount(0, $list);
    }

    public function testCount()
    {
        $list = new ExpressionList(new EmptyExpression());
        $this->assertNotNull($list);
        $this->assertCount(1, $list);
    }

    public function testIterate()
    {
        $list = new ExpressionList(new EmptyExpression(), new EmptyExpression(), new EmptyExpression());
        $this->assertCount(3, $list);
        $this->assertContainsOnly(EmptyExpression::class, $list);
    }
}
