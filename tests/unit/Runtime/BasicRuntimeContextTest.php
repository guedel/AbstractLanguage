<?php

/*
 * The MIT License
 *
 * Copyright 2021 Guedel <guedel87@live.fr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Guedel\Tests\Unit\AL\Runtime;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\BasicRuntimeContext;
use Guedel\AL\Declaration\{
  FunctionDecl,
  ProcedureDecl,
  VariableDecl,
  TypeDecl,
  ParametersList
};
use Guedel\AL\Datatype\Any;
use Guedel\AL\Statement\StatementList;

/**
 * Description of BasicRuntimeContextTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers \Guedel\AL\Runtime\BasicRuntimeContext
 */
class BasicRuntimeContextTest extends TestCase
{
  private ?BasicRuntimeContext $context = null;
  public function setUp(): void
  {
    $this->context = new BasicRuntimeContext(null, "sample");
  }

  public function testConstruct()
  {
    $this->assertEquals("sample", $this->context->getName());
    $this->assertNull($this->context->getParent());
  }

  public function testAddFunction()
  {
    $decl = new FunctionDecl("fun", Any::getType(), new ParametersList(), new StatementList());
    $this->context->addFunction($decl);
    $found = $this->context->findFunction("fun");
    $this->assertNotNull($found);
  }

  public function testAddProcedure()
  {
    $decl = new ProcedureDecl("proc", new ParametersList(), new StatementList());
    $this->context->addProcedure($decl);
    $found = $this->context->findProcedure("proc");
    $this->assertNotNull($found);
  }

  public function testAddType()
  {
    $decl = new TypeDecl("t", Any::getType());
    $this->context->addType($decl);
    $found = $this->context->findtype("t");
    $this->assertNotNull($found);
  }

  public function testAddVariable()
  {
    $decl = new VariableDecl("v");
    $this->context->addVariable($decl);
    $found = $this->context->findVariable("v");
    $this->assertNotNull($found);
  }

  public function testPushParent()
  {
    $ctx = new BasicRuntimeContext($this->context, "sp");
    $this->assertSame($this->context, $ctx->getParent());
  }
}
