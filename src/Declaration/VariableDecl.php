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

use Guedel\AL\Runtime\Visitor;
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
    private readonly Type $type;
    private mixed $value;

    public function __construct($name, Type $type = null)
    {
        parent::__construct($name);
        $this->type = $type ?? Any::getType();
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setValue(mixed $value): void
    {
        $this->value = ($value instanceof Value) ? $value : new Value($value);
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->declareVariable($this);
    }
}
