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

use Guedel\AL\Statement\Statement;
use Guedel\AL\Datatype\Type;
use Guedel\AL\Runtime\Visitor;

/**
 * FUNCTION $name ($arguments) : $returntype IS $body
 *
 * @author Guedel <guedel87@live.fr>
 */
class FunctionDecl extends ProcedureDecl
{
    private $returntype;


    public function __construct(
        string $name,
        Type $returntype,
        ParametersList $arguments = null,
        Statement $body = null,
    ) {
        parent::__construct($name, $arguments, $body);
        $this->returntype = $returntype;
    }

    public function getReturnType(): Type
    {
        return $this->returntype;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->declareFunction($this);
    }
}
