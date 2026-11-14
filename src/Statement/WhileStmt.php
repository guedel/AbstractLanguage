<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Statement;

use Guedel\AL\Expression\Valuable;
use Guedel\AL\Runtime\Visitor;

/**
 *
 *  WHILE $test DO $block
 *
 * @author Guedel <guedel87@live.fr>
 */
class WhileStmt implements Statement
{
    private $test;
    private $statement;

    public function __construct(Valuable $test, ?Statement $block = null)
    {
        $this->test = $test;
        $this->statement = $block;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitWhileStmt($this);
    }

    public function getTest(): Valuable
    {
        return $this->test;
    }

    public function getStatement(): ?Statement
    {
        return $this->statement;
    }
}
