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

/**
 * Declaration of type
 *
 * @author Guedel <guedel87@live.fr>
 */
class TypeDecl extends NamedDeclaration
{
    public function __construct(
        string $name,
        private readonly Type $definition
    ) {
        parent::__construct($name);
    }

    public function getDefinition(): Type
    {
        return $this->definition;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->declareType($this);
    }
}
