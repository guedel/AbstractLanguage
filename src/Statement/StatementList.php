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

use Guedel\AL\Runtime\Visitor;

/**
 * Collection of statements
 *
 * @author Guedel <guedel87@live.fr>
 */
class StatementList implements Statement, \IteratorAggregate, \Countable
{
    private $statements;

    public function __construct(Statement ...$statements)
    {
        $this->statements = $statements;
    }

    public function add(Statement $statement)
    {
        $this->statements[] = $statement;
        return $this;
    }

    public function last(): ?Statement
    {
        if (0 < $this->count()) {
            return $this->statements[array_key_last($this->statements)];
        }
        return null;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->statements);
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitStatementList($this);
    }

    public function count(): int
    {
        return count($this->statements);
    }
}
