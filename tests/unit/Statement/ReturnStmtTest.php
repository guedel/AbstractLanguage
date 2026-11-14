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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Statement\ReturnStmt;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of ReturnStmtTest
 *
 * @author Guedel <guedel87@live.fr>
 */
#[CoversClass(ReturnStmt::class)]
#[CoversClass(ExpressionList::class)]
class ReturnStmtTest extends TestCase
{
    public function testReturnSimple()
    {
        $r = new ReturnStmt();
        $this->assertEquals('RETURN', $r->accept(new TestVisitor()));
    }
}
