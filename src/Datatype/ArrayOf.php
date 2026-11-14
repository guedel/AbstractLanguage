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

use Guedel\AL\Runtime\Visitor;

/**
 * Description of ArrayOf
 *
 * @author Guedel <guedel87@live.fr>
 */
class ArrayOf implements Type
{
    public function __construct(
        private readonly Type $type,
        private readonly ?int $lowerbound = null,
        private readonly ?int $upperbound = null
    ) {
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

    public function accept(Visitor $visitor)
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
