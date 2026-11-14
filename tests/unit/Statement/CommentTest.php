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
use Guedel\AL\Statement\Comment;
use Guedel\Tests\Mock\AL\TestVisitor;

/**
 * Description of ReturnStmtTest
 *
 * @author Guedel <guedel87@live.fr>
 */
#[CoversClass(Comment::class)]
class CommentTest extends TestCase
{
    public function testComment(): void
    {
        $message = "Commentaire";
        $r = new Comment($message);
        $this->assertEquals($message, $r->getMessage());
    }

    public function testVoidComment(): void
    {
        $r = new Comment();
        $this->assertNull($r->getMessage());
    }
}
