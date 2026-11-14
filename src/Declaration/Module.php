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
 * Module $name
 * $statements
 *
 * @author Guedel <guedel87@live.fr>
 */
class Module extends NamedDeclaration
{
    private $statements;

    public function __construct($name, Statement ...$statements)
    {
        parent::__construct($name);
        $this->statements = new StatementList(...$statements);
    }

    public function getStatements(): StatementList
    {
        return $this->statements;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->declareModule($this);
    }
}
