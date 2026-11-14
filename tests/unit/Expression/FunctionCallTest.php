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
use Guedel\AL\Expression\FunctionCall;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of FunctionCallTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Expression\FunctionCall
 */
class FunctionCallTest extends TestCase
{
    private $function;
    private $visitor;

    public function setUp(): void
    {
        $this->function = new FunctionCall("cos");
        $this->visitor = new TestVisitor();
    }

    public function testConstruction()
    {
        $this->assertEquals('cos', $this->function->getName());
    }

    public function testEvaluate()
    {
        $this->assertEquals(0.66, $this->function->evaluate($this->visitor));
    }
}
