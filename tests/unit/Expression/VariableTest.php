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
use Guedel\AL\Expression\Variable;

/**
 * Description of VariableTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers \Guedel\AL\Expression\Variable
 */
class VariableTest extends TestCase
{
    public function testConstruct()
    {
        $var = new Variable("a");
        $this->assertEquals("a", $var->getVarname());
    }

    public function testAccept()
    {
        $var = new Variable('num');
        $this->assertEquals('124', $var->evaluate(new \Guedel\Tests\Mock\AL\TestVisitor()));
    }
}
