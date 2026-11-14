<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
