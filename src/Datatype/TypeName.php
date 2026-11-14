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
 * Utilisation de types nommés
 *
 * @author Guedel <guedel87@live.fr>
 */
class TypeName implements Type
{
    // Quelque types de base
    public const DT_ANY = 'any';
    public const DT_INTEGER = 'int';
    public const DT_FLOAT = 'float';
    public const DT_NUMBER = 'number';
    public const DT_STRING = 'string';

    private $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitTypename($this);
    }

    public function getSignature(): string
    {
        return 'alias:' . $this->name;
    }
}
