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
 * Description of Reference
 *
 * @author Guedel <guedel87@live.fr>
 */
class Reference implements Type
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitReference($this);
    }

    public function getSignature(): string
    {
        return '&(' . $this->type->getSignature() . ')';
    }
}
