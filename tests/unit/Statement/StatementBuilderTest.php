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
use Guedel\AL\Builder;
use Guedel\AL\Datatype\TypeName;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Declaration\NamedDeclaration;
use Guedel\AL\Expression\Value;
use Guedel\AL\Statement\AssignStmt;
use Guedel\AL\Statement\StatementBuilder;
use Guedel\AL\Statement\StatementList;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of ReturnStmtTest
 *
 * @author Guedel <guedel87@live.fr>
 */
#[CoversClass(StatementBuilder::class)]
#[CoversClass(Builder::class)]
#[UsesClass(TypeName::class)]
#[UsesClass(VariableDecl::class)]
#[UsesClass(StatementList::class)]
#[UsesClass(NamedDeclaration::class)]
#[UsesClass(Value::class)]
#[UsesClass(AssignStmt::class)]
class StatementBuilderTest extends TestCase
{
    private Builder $sut;

    protected function setUp(): void
    {
        $this->sut = new Builder();
    }

    public function testDeclareVariable(): void
    {
        $type = new TypeName(TypeName::DT_VOID);
        $varname = 'myVar';
        $this->sut->stmtVariable($varname, $type);
        $this->assertEquals(1, $this->sut->getStatements()->count());
        $stmt = $this->sut->getStatements()->last();
        $this->assertInstanceOf(VariableDecl::class, $stmt);
        $this->assertEquals($varname, $stmt->getName());
        $this->assertSame($type, $stmt->getType());
    }

    public function testAssignValue(): void
    {
        $value = new Value('hello');
        $this->sut->let('myVar', $value);
        $this->assertEquals(1, $this->sut->getStatements()->count());
        $stmt = $this->sut->getStatements()->last();
        $this->assertInstanceOf(AssignStmt::class, $stmt);
        $this->assertSame($value, $stmt->getExpression());
    }
}
