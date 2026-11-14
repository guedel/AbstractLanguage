<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Datatype;

/**
 * Description of Enumeration
 *
 * @author Guedel <guedel87@live.fr>
 */
class Enumeration implements Type
{
    private $symbols;

    public function __construct(string ...$symbols)
    {
        $this->symbols = $symbols;
    }

    public function getSymbols()
    {
        return $this->symbols;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitEnumeration($this);
    }

    public function getSignature(): string
    {
        $ret = 'enum(';
        $ret .= implode(',', $this->symbols);
        $ret .= ')';
        return $ret;
    }
}
