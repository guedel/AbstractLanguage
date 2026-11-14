<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\AL\Expression;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\Value;

/**
 * Description of ValueTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Expression\Value
 */
class ValueTest extends TestCase
{
    public function testConstruct()
    {
        $v = new Value(1234);
        $this->assertEquals(1234, $v->getValue());
    }

    public function testEvaluate()
    {
        $v = new Value(123);
        $visit = new \Guedel\Tests\Mock\AL\TestVisitor();
        $this->assertEquals(123, $v->evaluate($visit));
    }
}
