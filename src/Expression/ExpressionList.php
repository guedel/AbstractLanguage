<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Expression;

/**
 * List of Expression
 *
 * @author Guedel <guedel87@live.fr>
 */
class ExpressionList implements \IteratorAggregate, \Countable
{
    private $expressions;

    public function __construct(Valuable ...$expressions)
    {
        $this->expressions = $expressions;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->expressions);
    }

    public function count(): int
    {
        return count($this->expressions);
    }
}
