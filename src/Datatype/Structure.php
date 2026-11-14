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

use Guedel\AL\Declaration\VariableDecl;

/**
 * Description of Structure
 *
 * @author Guedel <guedel87@live.fr>
 */
class Structure implements Type
{
    /**
     *
     * @var VariableDecl[]
     */
    private array $attributes;

    public function __construct(VariableDecl ...$attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return VariableDecl[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitStructure($this);
    }

    public function getSignature(): string
    {
        $ret = '{';
        $first = true;
        foreach ($this->attributes as $attr) {
            if ($first) {
                $first = false;
            } else {
                $ret .= ';';
            }
            $ret .= $attr->getType()->getSignature();
        }
        return $ret . '}';
    }
}
