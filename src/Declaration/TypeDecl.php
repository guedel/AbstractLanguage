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

/**
 * Declaration of type
 *
 * @author Guedel <guedel87@live.fr>
 */
class TypeDecl extends NamedDeclaration
{
    private $definition;

    public function __construct(string $name, Type $definition)
    {
        parent::__construct($name);
        $this->definition = $definition;
    }

    public function getDefinition(): Type
    {
        return $this->definition;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->declareType($this);
    }
}
