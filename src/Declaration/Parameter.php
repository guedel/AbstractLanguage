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

/**
 * Definition of a function or procedure parameter
 *
 * @author Guedel <guedel87@live.fr>
 */
class Parameter extends VariableDecl
{
    public const string INPUT = 'IN';
    public const string OUTPUT = 'OUT';
    public const string INOUT = 'INOUT';
    public const string RET = 'RETURN';

    public function __construct(
        string $name,
        private readonly string $direction,
        \Guedel\AL\Datatype\Type $type = null
    ) {
        parent::__construct($name, $type);
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->declareParameter($this);
    }
}
