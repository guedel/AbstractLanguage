<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\AL\Statement;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Statement\StatementList;
use Guedel\Tests\Mock\AL\EmptyStatement;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of StatementListTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Statement\StatementList
 */
class StatementListTest extends TestCase
{
    /**
     *
     */
    public function testEmptyList()
    {
        $list = new StatementList();
        $this->assertCount(0, $list);
    }

    public function testCountElementList()
    {
        $list = new StatementList(new EmptyStatement());
        $this->assertCount(1, $list);
        $list->add(new EmptyStatement());
        $this->assertCount(2, $list);
    }

    public function testEnumElementList()
    {
        $visitor = new TestVisitor();
        $list = new StatementList(new EmptyStatement(), new EmptyStatement());
        $this->assertCount(2, $list);
        foreach ($list as $item) {
            $this->assertInstanceOf(EmptyStatement::class, $item);
            $this->assertEquals('EMPTY', $item->accept($visitor));
        }
    }
}
