<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Statement;

use Guedel\AL\Expression\Expression;
use Guedel\AL\Statement\Statement;
use Guedel\AL\Expression\Valuable;

/**
 * FOR EACH $varname IN $collection DO $stmt
 *
 * @author Guedel <guedel87@live.fr>
 */
class ForEachStmt implements Statement
{
    public function __construct(
        private readonly string $varname,
        private readonly Valuable $collection,
        private readonly ?Statement $statement = null
    ) {
    }

    public function getVarname(): string
    {
        return $this->varname;
    }

    public function getCollection(): Valuable
    {
        return $this->collection;
    }

    public function getStatement(): ?Statement
    {
        return $this->statement;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitForEachStmt($this);
    }
}
