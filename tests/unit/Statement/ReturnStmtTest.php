<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
