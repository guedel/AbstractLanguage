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
use Guedel\AL\Statement\StatementList;

#[CoversClass(Builder::class)]
#[UsesClass(StatementList::class)]
final class BuilderTest extends TestCase
{
    public function testCreateFirst(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(Builder::class, $builder);
        $this->assertObjectHasProperty('statements', $builder);
        $this->assertInstanceOf(StatementList::class, $builder->getStatements());
        $end = $builder->stmtEnd();
        $this->assertNull($end);
    }
}
