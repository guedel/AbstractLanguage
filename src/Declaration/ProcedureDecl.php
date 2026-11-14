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

use Guedel\AL\Statement\StatementList;
use Guedel\AL\Statement\Statement;

/**
* PROCEDURE $name ($parameters) IS $body
*
* @author Guedel <guedel87@live.fr>
*/
class ProcedureDecl extends NamedDeclaration
{
    private ?ParametersList $parameters;
    private ?Statement $body;

    public function __construct(string $name, ?ParametersList $parameters = null, ?Statement $body = null)
    {
        parent::__construct($name);
        if ($parameters === null) {
            $this->parameters = new ParametersList();
        } else {
            $this->parameters = $parameters;
        }
        if ($body instanceof StatementList) {
            $this->body = $body;
        } else {
            $this->body = new StatementList($body);
        }
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->declareProcedure($this);
    }

    public function getParameters(): ?ParametersList
    {
        return $this->parameters;
    }

    public function getBody(): ?Statement
    {
        return $this->body;
    }
}
