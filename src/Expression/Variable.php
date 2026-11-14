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
 * Store value in memory
 *
 * @author Guedel <guedel87@live.fr>
 */
class Variable implements Valuable
{
    private $varname;

    public function __construct(string $varname)
    {
        $this->varname = $varname;
    }

    public function getVarname(): string
    {
        return $this->varname;
    }

    public function evaluate(Visitor $visitor)
    {
        return $visitor->evalVariable($this);
    }
}
