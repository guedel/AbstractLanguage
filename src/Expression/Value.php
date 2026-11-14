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

use Guedel\AL\Runtime\Visitor;

/**
 * Simple value
 *
 * @author Guedel <guedel87@live.fr>
 */
class Value implements Valuable
{
    public function __construct(private readonly mixed $value)
    {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inherit
     */
    public function evaluate(Visitor $visitor)
    {
        return $visitor->evalValue($this);
    }
}
