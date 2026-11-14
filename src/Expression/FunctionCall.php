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
 * call of a function
 * $name($parameters)
 *
 * @author Guedel <guedel87@live.fr>
 */
class FunctionCall implements Valuable
{
    private $name;
    private $parameters;

    public function __construct($name, ...$parameters)
    {
        $this->name = $name;
        $this->parameters = new ExpressionList(... $parameters);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParameters(): ExpressionList
    {
        return $this->parameters;
    }

    /**
     *
     * @param \Guedel\AL\Runtime\Visitor $visitor
     * @return mixed
     */
    public function evaluate(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->evalFunctionCall($this);
    }
}
