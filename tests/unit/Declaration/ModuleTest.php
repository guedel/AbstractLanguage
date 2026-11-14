<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\AL\Declaration;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Declaration\Module;
use Guedel\Tests\Mock\AL\EmptyStatement;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of ModuleTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers \Guedel\AL\Declaration\Module
 */
class ModuleTest extends TestCase
{
    public function testCreateEmpty()
    {
        $m = new Module("Test");
        $this->assertEquals("Test", $m->getName());
        $this->assertCount(0, $m->getStatements());
    }

    public function testCreateOne()
    {
        $m = new Module("Test", new EmptyStatement());
        $this->assertCount(1, $m->getStatements());
    }

    public function testAccept()
    {
        $m = new Module("Test");
        $ret = $m->accept(new TestVisitor());
        $this->assertEquals("MODULE Test", $ret);
    }
}
