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

use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Expression\Valuable;
use Guedel\AL\Runtime\Visitor;

/**
 * Call $name With $parameters
 *
 * @author Guedel <guedel87@live.fr>
 */
class ProcedureCall implements Statement
{
    private $name;
    private $parameters;

    public function __construct(string $name, Valuable ...$parameters)
    {
        $this->name = $name;
        $this->parameters = new ExpressionList(... $parameters);
    }
    //put your code here
    public function accept(Visitor $visitor)
    {
        $visitor->visitProcedureCall($this);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): ExpressionList
    {
        return $this->parameters;
    }
}
