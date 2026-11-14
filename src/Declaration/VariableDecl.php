<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Declaration;

use Guedel\AL\Datatype\Type;
use Guedel\AL\Datatype\Any;
use Guedel\AL\Expression\Value;

/**
 * Declaration of a variable
 * VARIABLE $name : $type
 *
 * @author Guedel <guedel87@live.fr>
 */
class VariableDecl extends NamedDeclaration
{
    private Type $type;
    private mixed $value;

    public function __construct($name, Type $type = null)
    {
        parent::__construct($name);
        if ($type == null) {
            $this->type = Any::getType();
        } else {
            $this->type = $type;
        }
    }

    public function getType(): \Guedel\AL\Datatype\Type
    {
        return $this->type;
    }

    public function setValue(mixed $value): void
    {
        if ($value instanceof Value) {
            $this->value = $value;
        } else {
            $this->value = new Value($value);
        }
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->declareVariable($this);
    }
}
