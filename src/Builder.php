<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL;

use Guedel\AL\Datatype\Type;
use Guedel\AL\Expression;
use Guedel\AL\Statement\StatementList;
use Guedel\AL\Statement\StatementBuilder;
use Guedel\AL\Expression\ExpressionBuilder;
use Guedel\AL\Declaration\DeclarationBuilder;
use Guedel\AL\Datatype\DatatypeBuilder;

/**
 * Build any class in Abstract Language
 *
 * @author Guedel <guedel87@live.fr>
 */
class Builder
{
    use StatementBuilder;
    use ExpressionBuilder;
    use DeclarationBuilder;
    use DatatypeBuilder;

    protected StatementList $statements;

    public function __construct(private ?Builder $parent = null)
    {
        $this->statements = new StatementList();
    }

    public function getStatements(): StatementList
    {
        return $this->statements;
    }

    protected function stmtBegin(): Builder
    {
        return new Builder($this);
    }

    public function stmtEnd(): ?Builder
    {
        $ret = $this->parent;
        // $this->statements = null;
        $this->parent = null;
        return $ret;
    }
}
