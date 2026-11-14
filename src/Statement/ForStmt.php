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

use Guedel\AL\Expression\Valuable;
use Guedel\AL\Runtime\Visitor;

/**
 * FOR $varname FROM $initial TO $final [STEP $increment] DO $statement
 *
 * @author Guedel <guedel87@live.fr>
 */
class ForStmt implements Statement
{
    public function __construct(
        private readonly string $varname,
        private readonly Valuable $initial,
        private readonly Valuable $final,
        private readonly Valuable $increment,
        private readonly ?Statement $statement = null,
    ) {
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitForStmt($this);
    }

    public function getVariableName(): string
    {
        return $this->varname;
    }

    public function getInitial(): Valuable
    {
        return $this->initial;
    }

    public function getFinal(): Valuable
    {
        return $this->final;
    }

    public function getIncrement(): Valuable
    {
        return $this->increment;
    }

    public function getStatement(): ?Statement
    {
        return $this->statement;
    }
}
