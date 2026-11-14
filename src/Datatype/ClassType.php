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
 * Description of ClassType
 *
 * @author Guedel <guedel87@live.fr>
 */
class ClassType extends Structure
{
    private $methods;

    public function __construct()
    {
        $this->methods = array();
    }

    public function &getMethods()
    {
        return $this->methods;
    }

    public function addMethod(\Guedel\AL\Declaration\ProcedureDecl $method): ClassType
    {
        $this->methods[$method->getName()] = $method;
        return $this;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitClass($this);
    }

    public function getSignature(): string
    {
        $ret = '{' . parent::getSignature();
        $first = true;
        foreach ($this->methods as $attr) {
            if ($first) {
                $first = false;
            } else {
                $ret .= ';';
            }
            $ret .= $attr->getSignature();
        }

        return $ret . '}';
    }
}
