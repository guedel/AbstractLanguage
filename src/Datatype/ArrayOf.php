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
 * Description of ArrayOf
 *
 * @author Guedel <guedel87@live.fr>
 */
class ArrayOf implements Type
{
    private Type $type;
    private ?int $lowerbound;
    private ?int $upperbound;

    public function __construct(Type $type, ?int $lowerbound = null, ?int $upperbound = null)
    {
        $this->type = $type;
        $this->lowerbound = $lowerbound;
        $this->upperbound = $upperbound;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getLowerbound(): ?int
    {
        return $this->lowerbound;
    }

    public function getUpperbound(): ?int
    {
        return $this->upperbound;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitArrayof($this);
    }

    public function getSignature(): string
    {
        $ret = 'array[';
        $ret .= $this->lowerbound;
        $ret .= ',';
        $ret .= $this->upperbound;
        $ret .= ']:' . $this->type->getSignature();
        return $ret;
    }
}
