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
use Guedel\AL\Statement\ReturnStmt;

/**
 * Description of ReturnStmtTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers Guedel\AL\Statement\ReturnStmt
 */
class ReturnStmtTest extends TestCase
{
    /**
    *
    */
    public function testReturnSimple()
    {
        $r = new ReturnStmt();
        $this->assertEquals('RETURN', $r->accept(new \Guedel\Tests\Mock\AL\TestVisitor()));
    }
}
